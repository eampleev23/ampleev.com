#!/usr/bin/env node

const fs = require('fs');
const http = require('http');
const https = require('https');
const os = require('os');
const path = require('path');
const readline = require('readline');
const { execFileSync } = require('child_process');

const repoRoot = path.resolve(__dirname, '..');

function parseArgs(argv) {
  const args = {
    home: os.homedir(),
    watch: false,
    interval: 15,
    dryRun: false,
  };

  for (let index = 2; index < argv.length; index += 1) {
    const arg = argv[index];

    if (arg === '--watch') {
      args.watch = true;
    } else if (arg === '--dry-run') {
      args.dryRun = true;
    } else if (arg.startsWith('--home=')) {
      args.home = arg.slice('--home='.length);
    } else if (arg === '--home') {
      args.home = argv[++index] || args.home;
    } else if (arg.startsWith('--interval=')) {
      args.interval = Number(arg.slice('--interval='.length)) || args.interval;
    } else if (arg === '--interval') {
      args.interval = Number(argv[++index]) || args.interval;
    }
  }

  return args;
}

function loadDotEnv(filePath) {
  if (!fs.existsSync(filePath)) {
    return;
  }

  for (const line of fs.readFileSync(filePath, 'utf8').split(/\r?\n/)) {
    const trimmed = line.trim();

    if (trimmed === '' || trimmed.startsWith('#')) {
      continue;
    }

    const equalsIndex = trimmed.indexOf('=');

    if (equalsIndex === -1) {
      continue;
    }

    const key = trimmed.slice(0, equalsIndex).trim();
    let value = trimmed.slice(equalsIndex + 1).trim();

    if (
      (value.startsWith('"') && value.endsWith('"')) ||
      (value.startsWith("'") && value.endsWith("'"))
    ) {
      value = value.slice(1, -1);
    }

    if (key && process.env[key] === undefined) {
      process.env[key] = value;
    }
  }
}

function jsonlFiles(directory) {
  if (!fs.existsSync(directory)) {
    return [];
  }

  const result = [];

  for (const entry of fs.readdirSync(directory, { withFileTypes: true })) {
    const itemPath = path.join(directory, entry.name);

    if (entry.isDirectory()) {
      result.push(...jsonlFiles(itemPath));
    } else if (entry.isFile() && itemPath.toLowerCase().endsWith('.jsonl')) {
      result.push(itemPath);
    }
  }

  return result.sort();
}

function emptyUsage() {
  return {
    input_tokens: 0,
    cached_input_tokens: 0,
    cache_creation_input_tokens: 0,
    cache_read_input_tokens: 0,
    output_tokens: 0,
    reasoning_output_tokens: 0,
    total_tokens: 0,
  };
}

function sumUsage(items) {
  const sum = emptyUsage();

  for (const item of items) {
    for (const key of Object.keys(sum)) {
      sum[key] += Number(item[key] || 0);
    }
  }

  return sum;
}

function aggregateCodexDesktopState(home) {
  const databasePath = path.join(home, '.codex/state_5.sqlite');

  if (!fs.existsSync(databasePath)) {
    return { ...emptyUsage(), session_count: 0, file_count: 0, desktop_sqlite_total_tokens: 0 };
  }

  try {
    const output = execFileSync('sqlite3', [
      databasePath,
      'SELECT COALESCE(SUM(tokens_used), 0), COUNT(*), MAX(updated_at) FROM threads;',
    ], { encoding: 'utf8' }).trim();
    const [total, threadCount, updatedAt] = output.split('|');
    const totalTokens = Number(total || 0);

    return {
      ...emptyUsage(),
      total_tokens: totalTokens,
      session_count: Number(threadCount || 0),
      file_count: 1,
      desktop_sqlite_total_tokens: totalTokens,
      desktop_updated_at: Number(updatedAt || 0),
    };
  } catch (error) {
    return {
      ...emptyUsage(),
      session_count: 0,
      file_count: 0,
      desktop_sqlite_total_tokens: 0,
      desktop_sqlite_error: error.message,
    };
  }
}

async function aggregateCodexJsonl(home) {
  const files = [
    ...jsonlFiles(path.join(home, '.codex/archived_sessions')),
    ...jsonlFiles(path.join(home, '.codex/sessions')),
  ];
  const totalsBySession = new Map();

  for (const filePath of files) {
    let sessionId = null;
    let lastUsage = null;
    const reader = readline.createInterface({
      input: fs.createReadStream(filePath),
      crlfDelay: Infinity,
    });

    for await (const line of reader) {
      if (!line.trim()) {
        continue;
      }

      let entry;

      try {
        entry = JSON.parse(line);
      } catch (error) {
        continue;
      }

      if (entry.type === 'session_meta') {
        sessionId = (entry.payload && entry.payload.id) || sessionId;
      }

      if (entry.type !== 'event_msg') {
        continue;
      }

      const payload = entry.payload || {};

      if (payload.type !== 'token_count') {
        continue;
      }

      const usage = payload.info && payload.info.total_token_usage;

      if (usage) {
        lastUsage = {
          input_tokens: Number(usage.input_tokens || 0),
          cached_input_tokens: Number(usage.cached_input_tokens || 0),
          cache_creation_input_tokens: 0,
          cache_read_input_tokens: 0,
          output_tokens: Number(usage.output_tokens || 0),
          reasoning_output_tokens: Number(usage.reasoning_output_tokens || 0),
          total_tokens: Number(usage.total_tokens || 0),
        };
      }
    }

    if (!lastUsage) {
      continue;
    }

    const key = sessionId || filePath;
    const previous = totalsBySession.get(key);

    if (!previous || lastUsage.total_tokens > previous.total_tokens) {
      totalsBySession.set(key, lastUsage);
    }
  }

  return {
    ...sumUsage(totalsBySession.values()),
    session_count: totalsBySession.size,
    file_count: files.length,
  };
}

async function aggregateCodex(home) {
  const desktop = aggregateCodexDesktopState(home);

  if (desktop.total_tokens > 0) {
    return {
      ...desktop,
      jsonl_total_tokens: null,
      source: 'codex_desktop_state_sqlite',
    };
  }

  const jsonl = await aggregateCodexJsonl(home);

  return {
    ...jsonl,
    jsonl_total_tokens: jsonl.total_tokens,
    desktop_sqlite_total_tokens: desktop.total_tokens,
    source: 'codex_jsonl',
  };
}

async function aggregateClaude(home) {
  const files = jsonlFiles(path.join(home, '.claude/projects'));
  const usageByRequest = new Map();

  for (const filePath of files) {
    const reader = readline.createInterface({
      input: fs.createReadStream(filePath),
      crlfDelay: Infinity,
    });

    for await (const line of reader) {
      if (!line.trim()) {
        continue;
      }

      let entry;

      try {
        entry = JSON.parse(line);
      } catch (error) {
        continue;
      }

      if (entry.type !== 'assistant') {
        continue;
      }

      const usage = entry.message && entry.message.usage;

      if (!usage) {
        continue;
      }

      const requestKey = entry.requestId ||
        (entry.message && entry.message.id) ||
        entry.uuid ||
        `${filePath}:${JSON.stringify(usage)}`;

      if (usageByRequest.has(requestKey)) {
        continue;
      }

      const inputTokens = Number(usage.input_tokens || 0);
      const cacheCreationTokens = Number(usage.cache_creation_input_tokens || 0);
      const cacheReadTokens = Number(usage.cache_read_input_tokens || 0);
      const outputTokens = Number(usage.output_tokens || 0);

      usageByRequest.set(requestKey, {
        input_tokens: inputTokens,
        cached_input_tokens: cacheCreationTokens + cacheReadTokens,
        cache_creation_input_tokens: cacheCreationTokens,
        cache_read_input_tokens: cacheReadTokens,
        output_tokens: outputTokens,
        reasoning_output_tokens: 0,
        total_tokens: inputTokens + cacheCreationTokens + cacheReadTokens + outputTokens,
      });
    }
  }

  return {
    ...sumUsage(usageByRequest.values()),
    request_count: usageByRequest.size,
    file_count: files.length,
  };
}

async function aggregate(home) {
  const [codex, claude] = await Promise.all([
    aggregateCodex(home),
    aggregateClaude(home),
  ]);

  return {
    total_tokens: codex.total_tokens + claude.total_tokens,
    claude_tokens: claude.total_tokens,
    codex_tokens: codex.total_tokens,
    captured_at: new Date().toISOString(),
    source_host: process.env.AI_USAGE_SOURCE_HOST || os.hostname(),
    source_id: process.env.AI_USAGE_SOURCE_ID || os.hostname() || 'default',
    providers: {
      codex,
      claude,
    },
  };
}

function postJson(endpoint, token, payload) {
  return new Promise((resolve, reject) => {
    const url = new URL(endpoint);
    const body = JSON.stringify(payload);
    const client = url.protocol === 'http:' ? http : https;
    const request = client.request({
      method: 'POST',
      hostname: url.hostname,
      port: url.port || undefined,
      path: `${url.pathname}${url.search}`,
      headers: {
        Authorization: `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Content-Length': Buffer.byteLength(body),
      },
    }, (response) => {
      let responseBody = '';
      response.setEncoding('utf8');
      response.on('data', (chunk) => {
        responseBody += chunk;
      });
      response.on('end', () => {
        if (response.statusCode >= 200 && response.statusCode < 300) {
          resolve(responseBody);
        } else {
          reject(new Error(`HTTP ${response.statusCode}: ${responseBody}`));
        }
      });
    });

    request.on('error', reject);
    request.write(body);
    request.end();
  });
}

async function syncOnce(args) {
  const payload = await aggregate(args.home);

  console.log('AI usage snapshot');
  console.log(`Total:  ${payload.total_tokens.toLocaleString('ru-RU')}`);
  console.log(`Claude: ${payload.claude_tokens.toLocaleString('ru-RU')}`);
  console.log(`Codex:  ${payload.codex_tokens.toLocaleString('ru-RU')}`);
  console.log(`Source: ${payload.source_id}`);

  if (args.dryRun) {
    console.log(JSON.stringify(payload, null, 2));
    return;
  }

  const endpoint = process.env.AI_USAGE_SYNC_ENDPOINT;
  const token = process.env.AI_USAGE_SYNC_TOKEN;

  if (!endpoint || !token) {
    throw new Error('AI_USAGE_SYNC_ENDPOINT and AI_USAGE_SYNC_TOKEN are required.');
  }

  const response = await postJson(endpoint, token, payload);
  console.log('Synced successfully.');
  console.log(response);
}

async function main() {
  loadDotEnv(path.join(repoRoot, '.env'));

  const args = parseArgs(process.argv);

  if (!args.watch) {
    await syncOnce(args);
    return;
  }

  console.log(`Watching AI usage every ${args.interval} seconds. Press Ctrl+C to stop.`);

  for (;;) {
    try {
      await syncOnce(args);
    } catch (error) {
      console.error(error.stack || error.message);
    }

    await new Promise((resolve) => setTimeout(resolve, args.interval * 1000));
  }
}

main().catch((error) => {
  console.error(error.stack || error.message);
  process.exit(1);
});
