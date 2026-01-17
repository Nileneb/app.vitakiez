<?php

use App\Http\Controllers\ApiTokenUiController;
use App\Http\Controllers\AuthorityController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\SourceEvidenceController;
use App\Http\Controllers\WgController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('impressum', fn () => view('pages.legal.impressum'))->name('impressum');
Route::get('datenschutz', fn () => view('pages.legal.datenschutz'))->name('datenschutz');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
