<?php

namespace App\Http\Controllers;

use App\AiUsageSnapshot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class AiUsageSyncController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $syncToken = (string) config('services.ai_usage.sync_token');
        $requestToken = (string) ($request->bearerToken() ?: $request->header('X-AI-Usage-Token'));

        if ($syncToken === '' || $requestToken === '' || !hash_equals($syncToken, $requestToken)) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'total_tokens' => ['required', 'integer', 'min:0'],
            'claude_tokens' => ['required', 'integer', 'min:0'],
            'codex_tokens' => ['required', 'integer', 'min:0'],
            'captured_at' => ['nullable', 'date'],
            'source_host' => ['nullable', 'string', 'max:120'],
            'providers' => ['nullable', 'array'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $payload = [
            'total_tokens' => (int) $data['total_tokens'],
            'claude_tokens' => (int) $data['claude_tokens'],
            'codex_tokens' => (int) $data['codex_tokens'],
            'captured_at' => $data['captured_at'] ?? now()->toIso8601String(),
            'source_host' => $data['source_host'] ?? null,
            'providers' => $data['providers'] ?? [],
        ];
        $payloadHash = hash('sha256', json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $snapshot = AiUsageSnapshot::firstOrCreate(
            ['payload_hash' => $payloadHash],
            [
                'total_tokens' => $payload['total_tokens'],
                'claude_tokens' => $payload['claude_tokens'],
                'codex_tokens' => $payload['codex_tokens'],
                'captured_at' => Carbon::parse($payload['captured_at']),
                'source_host' => $payload['source_host'],
                'provider_payload' => $payload['providers'],
            ]
        );

        return response()->json([
            'message' => $snapshot->wasRecentlyCreated ? 'Snapshot stored.' : 'Snapshot already exists.',
            'snapshot_id' => $snapshot->id,
            'created' => $snapshot->wasRecentlyCreated,
        ]);
    }
}
