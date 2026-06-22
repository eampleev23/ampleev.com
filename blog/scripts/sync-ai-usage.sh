#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BLOG_DIR="$(cd "${SCRIPT_DIR}/.." && pwd)"
HOST_HOME="${HOME}"
HOST_AI_HOME="/host-home"
IMAGE="${AI_USAGE_DOCKER_IMAGE:-blog-app}"
NETWORK_ARGS=()

if ! command -v docker >/dev/null 2>&1; then
  echo "Docker is required to run the AI usage sync script." >&2
  exit 1
fi

if docker network inspect "${AI_USAGE_DOCKER_NETWORK:-blog_app-network}" >/dev/null 2>&1; then
  NETWORK_ARGS=(--network "${AI_USAGE_DOCKER_NETWORK:-blog_app-network}")
fi

docker run --rm \
  --platform linux/amd64 \
  "${NETWORK_ARGS[@]}" \
  -v "${BLOG_DIR}:/var/www" \
  -v "${HOST_HOME}/.codex:${HOST_AI_HOME}/.codex:ro" \
  -v "${HOST_HOME}/.claude:${HOST_AI_HOME}/.claude:ro" \
  -w /var/www \
  "${IMAGE}" \
  php artisan ai-usage:sync --home="${HOST_AI_HOME}" "$@"
