<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class N8nClient
{
    /**
     * Create or update a per-user API Key credential via n8n REST API.
     */
    public function ensureUserCredential(string $userId, string $userEmail, string $apiKey): ?string
    {
        $apiUrl = rtrim((string) config('services.n8n.api_url'), '/');
        $token = (string) config('services.n8n.api_token');
        if (!$apiUrl || !$token) {
            return null;
        }

        $name = 'vitakiez-user-'.$userId;
        $payload = [
            'name' => $name,
            'type' => 'httpHeaderAuth',
            'data' => [
                'name' => 'X-User-Key',
                'value' => $apiKey,
            ],
        ];

        $response = Http::withToken($token)->post($apiUrl.'/rest/credentials', $payload);
        if ($response->successful()) {
            return (string) data_get($response->json(), 'id');
        }

        return null;
    }
}
