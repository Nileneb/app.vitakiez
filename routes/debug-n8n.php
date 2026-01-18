<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
 * Debug Route: Test n8n Chat Flow
 * Simulates the complete chat → WG-Data → Agent → Response flow
 */

Route::get('/debug/n8n-chat', function () {
    $wgId = '019bcdb0-e369-7221-8a39-fc7e22ce69d6';
    $chatInput = 'Hallo, wir brauchen Hilfe mit dem WG-Zuschlag';

    return [
        'step1' => 'Calling n8n chat webhook with metadata',
        'wg_id' => $wgId,
        'chat_input' => $chatInput,
        'payload' => [
            'chatInput' => $chatInput,
            'metadata' => [
                'X-WG-ID' => $wgId,
                'timestamp' => now()->toIso8601String(),
            ],
        ],
        'instructions' => [
            'POST to: https://n8n.linn.games/webhook/5dd82489-f71f-4c10-97aa-564fb844ec2d/chat',
            'Headers: Content-Type: application/json',
            'Body: (see payload above)',
            'Expected: Chat response from AI Agent',
        ],
    ];
});

Route::get('/debug/n8n-getwg-direct', function () {
    $token = config('services.n8n.api_token') ?? env('N8N_LARAVEL_API_TOKEN');
    $wgId = '019bcdb0-e369-7221-8a39-fc7e22ce69d6';

    $response = Http::withToken($token)
        ->withHeaders(['Accept' => 'application/json'])
        ->get("https://app.vitakiez.de/api/wgs/{$wgId}");

    return [
        'step' => 'Test GetWG_Data HTTP Request',
        'token' => substr($token, 0, 10).'***',
        'url' => "https://app.vitakiez.de/api/wgs/{$wgId}",
        'status' => $response->status(),
        'headers' => $response->headers(),
        'body' => $response->json() ?? $response->body(),
        'success' => $response->successful(),
    ];
});

Route::post('/debug/n8n-test-agent', function () {
    $wgId = '019bcdb0-e369-7221-8a39-fc7e22ce69d6';
    $chatInput = request('chat_input', 'Hallo, wir brauchen Hilfe mit dem WG-Zuschlag');
    $token = config('services.n8n.api_token') ?? env('N8N_LARAVEL_API_TOKEN');

    // Step 1: Get WG Data
    $wgResponse = Http::withToken($token)
        ->withHeaders(['Accept' => 'application/json'])
        ->get("https://app.vitakiez.de/api/wgs/{$wgId}");

    if (!$wgResponse->successful()) {
        return response()->json([
            'error' => 'Failed to fetch WG data',
            'status' => $wgResponse->status(),
            'body' => $wgResponse->json(),
        ], 400);
    }

    $wgData = $wgResponse->json();

    // Step 2: Call n8n Chat
    $chatResponse = Http::post('https://n8n.linn.games/webhook/5dd82489-f71f-4c10-97aa-564fb844ec2d/chat', [
        'chatInput' => $chatInput,
        'metadata' => [
            'X-WG-ID' => $wgId,
            'wg_name' => $wgData['wg_name'] ?? null,
            'state' => $wgData['state'] ?? null,
        ],
    ]);

    return [
        'wg_data' => [
            'wg_id' => $wgData['wg_id'] ?? null,
            'wg_name' => $wgData['wg_name'] ?? null,
            'state' => $wgData['state'] ?? null,
        ],
        'chat_input' => $chatInput,
        'chat_response_status' => $chatResponse->status(),
        'chat_response' => $chatResponse->json() ?? $chatResponse->body(),
        'success' => $chatResponse->successful(),
    ];
});
