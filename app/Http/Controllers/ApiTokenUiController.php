<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiTokenUiController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $token = $request->user()->createToken(
            $request->input('name'),
            // abilities (optional): z.B. ['cases:write','evidence:write']
            []
        );

        // Wichtig: plainTextToken nur JETZT anzeigen (nicht speichern!)
        return back()->with('new_token', $token->plainTextToken);
    }

    public function revoke(Request $request, string $tokenId)
    {
        $request->user()->tokens()->where('id', $tokenId)->delete();
        return back()->with('status', 'Token successfully revoked');
    }
}
