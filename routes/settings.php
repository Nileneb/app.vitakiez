<?php

use App\Http\Controllers\ApiTokenUiController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::livewire('settings/profile', 'pages::settings.profile')->name('profile.edit');
    
    // API Tokens - using Blade view instead of Livewire for simplicity
    Route::get('settings/api-tokens', function () {
        return view('pages.settings.api-tokens', [
            'heading' => __('API Tokens'),
            'subheading' => __('Create and manage API tokens for integrations'),
        ]);
    })->name('api-tokens.show');

    // API Token management
    Route::post('settings/api-tokens', [ApiTokenUiController::class, 'create'])
        ->name('settings.api-tokens.create');
    Route::delete('settings/api-tokens/{tokenId}', [ApiTokenUiController::class, 'revoke'])
        ->name('settings.api-tokens.revoke');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('settings/password', 'pages::settings.password')->name('user-password.edit');
    Route::livewire('settings/appearance', 'pages::settings.appearance')->name('appearance.edit');

    Route::livewire('settings/two-factor', 'pages::settings.two-factor')
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
