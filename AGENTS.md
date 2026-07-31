# AGENTS.md — ampleev.com

## Project layout

- The Laravel application lives in `blog/`.
- Blade templates: `blog/resources/views/`.
- Public assets: `blog/public/assets/`.
- Deployment workflow: `.github/workflows/deploy.yml`.

## Required delivery workflow

For every user-authorized code, configuration, content, or asset change in this repository, finish the task end to end by default:

1. Implement the change.
2. Run checks proportional to the risk.
3. Commit only files that belong to the current task.
4. Push the commit to `origin master`.
5. Wait for the `Deploy to Production` GitHub Actions workflow to complete.
6. Verify the affected production URL or production behavior.

Do not stop after a local edit unless the user explicitly asks for a local-only change, asks not to commit or deploy, or the task is read-only research/review.

If deployment fails, investigate and fix it within the task scope. Do not report completion until production verification succeeds or a genuine external blocker is identified.

## Deployment

Every push to `master` deploys automatically through `.github/workflows/deploy.yml`.

The workflow:

1. Resets the production checkout to `origin/master`.
2. Runs pending migrations.
3. Synchronizes drafts.
4. Rebuilds Laravel caches and optimization state.
5. Rebuilds the AIЯ corpus.

Use:

```bash
git push origin master
gh run list --workflow=deploy.yml
gh run watch <run-id> --exit-status
```

After the workflow succeeds, confirm the production server is on the expected commit when relevant:

```bash
ssh simplecloud 'cd /var/www/ampleev.com/blog && git rev-parse HEAD'
```

## Dirty worktree safety

- The worktree often contains unrelated user changes.
- Never include unrelated modified or untracked files in a task commit.
- Stage explicit paths only; never use `git add .` or `git add -A`.
- Do not discard, overwrite, stash, or reformat unrelated work.
- Review the staged diff before committing.

## Production access

- Code changes go through `master` and GitHub Actions, never through manual edits on the server.
- Reading logs and running non-secret operational checks over the `simplecloud` SSH alias is allowed.
- Never print or modify secret values, API keys, passwords, or tokens.

## Laravel asset paths

Use `{{ asset('assets/...') }}` in Blade templates. Relative asset paths break on localized routes such as `/en/...`.
