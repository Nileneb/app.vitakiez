<?php

namespace App\Http\Controllers;

use App\Models\Authority;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorityController extends Controller
{
    /**
     * Display a listing of authorities.
     */
    public function index(): View
    {
        $authorities = Authority::latest('created_at')->get();

        return view('pages.tables.authorities', [
            'authorities' => $authorities,
        ]);
    }

    /**
     * Show the form for creating a new authority.
     */
    public function create(): View
    {
        return view('pages.authorities.create');
    }

    /**
     * Store a newly created authority in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'authority_type' => ['nullable', 'string', 'max:100'],
            'jurisdiction_state' => ['nullable', 'string', 'max:100'],
            'jurisdiction_district' => ['nullable', 'string', 'max:100'],
            'jurisdiction_municipality' => ['nullable', 'string', 'max:100'],
            'coverage_note' => ['nullable', 'string'],
            'website_url' => ['nullable', 'url'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address_text' => ['nullable', 'string'],
            'office_hours' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $authority = Authority::create([
            'id' => Str::uuid(),
            ...$validated,
        ]);

        return redirect()->route('authorities.show', $authority->id)
            ->with('success', 'Behörde erfolgreich erstellt.');
    }

    /**
     * Display the specified authority.
     */
    public function show(Authority $authority): View
    {
        return view('pages.authorities.show', [
            'authority' => $authority,
        ]);
    }

    /**
     * Show the form for editing the specified authority.
     */
    public function edit(Authority $authority): View
    {
        return view('pages.authorities.edit', [
            'authority' => $authority,
        ]);
    }

    /**
     * Update the specified authority in storage.
     */
    public function update(Request $request, Authority $authority): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'authority_type' => ['nullable', 'string', 'max:100'],
            'jurisdiction_state' => ['nullable', 'string', 'max:100'],
            'jurisdiction_district' => ['nullable', 'string', 'max:100'],
            'jurisdiction_municipality' => ['nullable', 'string', 'max:100'],
            'coverage_note' => ['nullable', 'string'],
            'website_url' => ['nullable', 'url'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address_text' => ['nullable', 'string'],
            'office_hours' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $authority->fill($validated);
        $authority->save();

        return redirect()->route('authorities.show', $authority->id)
            ->with('success', 'Behörde aktualisiert.');
    }

    /**
     * Delete the specified authority.
     */
    public function destroy(Authority $authority): RedirectResponse
    {
        $authority->delete();

        return redirect()->route('authorities.index')
            ->with('success', 'Behörde gelöscht.');
    }
}
