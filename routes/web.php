<?php

use App\Http\Controllers\ApiTokenUiController;
use App\Http\Controllers\AuthorityController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\SourceEvidenceController;
use App\Http\Controllers\WgController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('impressum', fn () => view('pages.legal.impressum'))->name('impressum');
Route::get('datenschutz', fn () => view('pages.legal.datenschutz'))->name('datenschutz');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Debug: Check WG-ID being sent to chat
    Route::get('debug/chat-wg-id', function () {
        $user = auth()->user();
        $wg = $user->activeWg ?? App\Models\Wg::where('owner_user_id', $user->id)->first();

        return response()->json([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'active_wg_id' => $user->active_wg_id,
            'resolved_wg' => $wg ? [
                'wg_id' => $wg->wg_id,
                'wg_name' => $wg->wg_name,
            ] : null,
        ]);
    })->name('debug.chat-wg-id');

    // WG Routes
    Route::resource('wgs', WgController::class);
    Route::patch('wgs/{wg}/activate', [WgController::class, 'activate'])->name('wgs.activate');

    // Case Routes
    Route::resource('cases', CaseController::class);

    // Issue Routes
    Route::resource('issues', IssueController::class);

    // Authority Routes
    Route::resource('authorities', AuthorityController::class);

    // Source Evidence Routes
    Route::resource('source-evidence', SourceEvidenceController::class);

    // Table Views
    Route::prefix('tables')->name('tables.')->group(function () {
        Route::get('wgs', fn () => view('pages.tables.wg'))->name('wgs');
        Route::get('cases', fn () => view('pages.tables.cases'))->name('cases');
        Route::get('issues', fn () => view('pages.tables.issues'))->name('issues');
        Route::get('authorities', fn () => view('pages.tables.authorities'))->name('authorities');
        Route::get('source-evidence', fn () => view('pages.tables.source_evidence'))->name('source-evidence');
    });

    // Settings
    Route::prefix('settings')->group(function () {
        Route::redirect('/', 'settings/profile');
        Route::livewire('profile', 'pages::settings.profile')->name('profile.edit');
        Route::livewire('password', 'pages::settings.password')->name('user-password.edit');
        Route::livewire('appearance', 'pages::settings.appearance')->name('appearance.edit');

        Route::livewire('two-factor', 'pages::settings.two-factor')
            ->middleware(
                when(
                    Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                    ['password.confirm'],
                    [],
                ),
            )
            ->name('two-factor.show');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('settings/api-tokens', function () {
        return view('pages.settings.api-tokens', [
            'heading' => __('API Tokens'),
            'subheading' => __('Create and manage API tokens for integrations'),
        ]);
    })->name('api-tokens.show');

    Route::post('settings/api-tokens', [ApiTokenUiController::class, 'create'])
        ->name('settings.api-tokens.create');
    Route::delete('settings/api-tokens/{tokenId}', [ApiTokenUiController::class, 'revoke'])
        ->name('settings.api-tokens.revoke');
});

// N8N Debug Routes
Route::get('/debug/n8n-chat', function () {
    $wgId = '019bcdb0-e369-7221-8a39-fc7e22ce69d6';
    $chatInput = 'Hallo, wir brauchen Hilfe mit dem WG-Zuschlag';
    
    return response()->json([
        'step1' => 'Test n8n Chat Webhook',
        'wg_id' => $wgId,
        'chat_input' => $chatInput,
        'payload' => [
            'chatInput' => $chatInput,
            'metadata' => ['X-WG-ID' => $wgId]
        ],
        'curl_command' => "curl -X POST -H 'Content-Type: application/json' https://n8n.linn.games/webhook/5dd82489-f71f-4c10-97aa-564fb844ec2d/chat -d '{\"chatInput\":\"$chatInput\",\"metadata\":{\"X-WG-ID\":\"$wgId\"}}'"
    ]);
});

Route::get('/debug/n8n-getwg', function () {
    $token = env('N8N_LARAVEL_API_TOKEN');
    $wgId = '019bcdb0-e369-7221-8a39-fc7e22ce69d6';
    
    $response = Http::withToken($token)
        ->withHeaders(['Accept' => 'application/json'])
        ->get("https://app.vitakiez.de/api/wgs/{$wgId}");
    
    return response()->json([
        'endpoint' => "/api/wgs/{$wgId}",
        'token_valid' => $response->status() === 200,
        'status' => $response->status(),
        'wg_data' => $response->json(),
    ]);
});

Route::post('/debug/n8n-test', function () {
    $wgId = '019bcdb0-e369-7221-8a39-fc7e22ce69d6';
    $chatInput = request('input', 'Hallo, Hilfe mit dem WG-Zuschlag');
    $token = env('N8N_LARAVEL_API_TOKEN');
    
    try {
        // Get WG
        $wgResponse = Http::withToken($token)
            ->withHeaders(['Accept' => 'application/json'])
            ->get("https://app.vitakiez.de/api/wgs/{$wgId}");
        
        // Call Chat
        $chatResponse = Http::post('https://n8n.linn.games/webhook/5dd82489-f71f-4c10-97aa-564fb844ec2d/chat', [
            'chatInput' => $chatInput,
            'metadata' => ['X-WG-ID' => $wgId]
        ]);
        
        return response()->json([
            'wg_status' => $wgResponse->status(),
            'wg_data' => $wgResponse->json(),
            'chat_status' => $chatResponse->status(),
            'chat_response' => $chatResponse->json() ?? $chatResponse->body(),
            'success' => $chatResponse->successful()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});
