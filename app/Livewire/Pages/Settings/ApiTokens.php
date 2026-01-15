<?php

namespace App\Livewire\Pages\Settings;

use Livewire\Component;

class ApiTokens extends Component
{
    public $tokenName = '';
    public $showNewToken = false;
    public $newToken = '';

    public function mount()
    {
        if (session('new_token')) {
            $this->showNewToken = true;
            $this->newToken = session('new_token');
        }
    }

    public function createToken()
    {
        $this->validate([
            'tokenName' => ['required', 'string', 'max:255'],
        ], [
            'tokenName.required' => 'Token name is required',
        ]);

        $token = auth()->user()->createToken(
            $this->tokenName,
            []
        );

        $this->showNewToken = true;
        $this->newToken = $token->plainTextToken;
        $this->tokenName = '';
        
        $this->dispatch('token-created');
    }

    public function revokeToken($tokenId)
    {
        auth()->user()->tokens()->where('id', $tokenId)->delete();
        $this->dispatch('token-revoked');
    }

    public function render()
    {
        return view('livewire.pages.settings.api-tokens', [
            'tokens' => auth()->user()->tokens()->latest()->get(),
        ]);
    }
}
