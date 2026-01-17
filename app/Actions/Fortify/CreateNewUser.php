<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
            'phone' => ['nullable', 'string', 'max:20'],
            'user_type' => ['nullable', 'in:bewohner,investor'],
            'pflegegrad' => ['nullable', 'string', 'max:50'],
            'einzug' => ['nullable', 'string', 'max:100'],
            'nachricht' => ['nullable', 'string', 'max:1000'],
            'interesse' => ['nullable', 'string', 'max:50'],
            'betrag' => ['nullable', 'string', 'max:50'],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'phone' => $input['phone'] ?? null,
            'user_type' => $input['user_type'] ?? null,
            'pflegegrad' => $input['pflegegrad'] ?? null,
            'einzug' => $input['einzug'] ?? null,
            'nachricht' => $input['nachricht'] ?? null,
            'interesse' => $input['interesse'] ?? null,
            'betrag' => $input['betrag'] ?? null,
        ]);
    }
}
