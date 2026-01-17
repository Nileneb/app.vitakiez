<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wg;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WgController extends Controller
{
    /**
     * Display a listing of all WGs for the authenticated user.
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $wgs = $user->wgs()->get();
        $activeWg = $user->active_wg_id;

        return view('pages.tables.wg', [
            'wgs' => $wgs,
            'activeWg' => $activeWg,
        ]);
    }

    /**
     * Show the form for creating a new WG.
     */
    public function create(): View
    {
        return view('pages.wgs.create');
    }

    /**
     * Store a newly created WG in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'wg_name' => ['required', 'string', 'max:255'],
            'address_text' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'municipality' => ['nullable', 'string', 'max:100'],
            'residents_total' => ['nullable', 'integer', 'min:1'],
            'residents_with_pg' => ['nullable', 'integer', 'min:0'],
            'target_group' => ['nullable', 'string', 'max:255'],
            'has_24h_presence' => ['nullable', 'boolean'],
            'has_presence_staff' => ['nullable', 'boolean'],
            'care_provider_mode' => ['nullable', 'string', 'max:100'],
            'lease_individual' => ['nullable', 'boolean'],
            'care_individual' => ['nullable', 'boolean'],
            'bundle_housing_care' => ['nullable', 'boolean'],
            'sgb_xi_used' => ['nullable', 'boolean'],
            'sgb_xii_involved' => ['nullable', 'boolean'],
            'sgb_v_hkp' => ['nullable', 'boolean'],
            'landesrecht_title' => ['nullable', 'string', 'max:255'],
            'landesrecht_url' => ['nullable', 'url'],
            'heimaufsicht_contact_hint' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $wg = $user->wgs()->create([
            'wg_id' => Str::uuid(),
            ...$validated,
            'owner_user_id' => Auth::id(),
        ]);

        // Set as active WG if it's the first one
        if (! $user->active_wg_id) {
            $user->update(['active_wg_id' => $wg->wg_id]);
        }

        return redirect()->route('wgs.show', $wg->wg_id)
            ->with('success', 'WG erfolgreich erstellt.');
    }

    /**
     * Display the specified WG.
     */
    public function show(Wg $wg): View
    {
        $this->authorize('view', $wg);

        return view('pages.wgs.show', [
            'wg' => $wg,
        ]);
    }

    /**
     * Show the form for editing the specified WG.
     */
    public function edit(Wg $wg): View
    {
        $this->authorize('update', $wg);

        return view('pages.wgs.edit', [
            'wg' => $wg,
        ]);
    }

    /**
     * Update the specified WG in storage.
     */
    public function update(Request $request, Wg $wg): RedirectResponse
    {
        $this->authorize('update', $wg);

        $validated = $request->validate([
            'wg_name' => ['required', 'string', 'max:255'],
            'address_text' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'municipality' => ['nullable', 'string', 'max:100'],
            'residents_total' => ['nullable', 'integer', 'min:1'],
            'residents_with_pg' => ['nullable', 'integer', 'min:0'],
            'target_group' => ['nullable', 'string', 'max:255'],
            'has_24h_presence' => ['nullable', 'boolean'],
            'has_presence_staff' => ['nullable', 'boolean'],
            'care_provider_mode' => ['nullable', 'string', 'max:100'],
            'lease_individual' => ['nullable', 'boolean'],
            'care_individual' => ['nullable', 'boolean'],
            'bundle_housing_care' => ['nullable', 'boolean'],
            'sgb_xi_used' => ['nullable', 'boolean'],
            'sgb_xii_involved' => ['nullable', 'boolean'],
            'sgb_v_hkp' => ['nullable', 'boolean'],
            'landesrecht_title' => ['nullable', 'string', 'max:255'],
            'landesrecht_url' => ['nullable', 'url'],
            'heimaufsicht_contact_hint' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $wg->update($validated);

        return redirect()->route('wgs.show', $wg->wg_id)
            ->with('success', 'WG aktualisiert.');
    }

    /**
     * Delete the specified WG.
     */
    public function destroy(Wg $wg): RedirectResponse
    {
        $this->authorize('delete', $wg);

        $wg->delete();

        // If it was the active WG, clear it
        /** @var User $user */
        $user = Auth::user();
        if ($user->active_wg_id === $wg->wg_id) {
            $user->update(['active_wg_id' => null]);
        }

        return redirect()->route('wgs.index')
            ->with('success', 'WG gelöscht.');
    }

    /**
     * Set the specified WG as the active WG.
     */
    public function activate(Wg $wg): RedirectResponse
    {
        $this->authorize('view', $wg);

        /** @var User $user */
        $user = Auth::user();
        $user->update(['active_wg_id' => $wg->wg_id]);

        return redirect()->route('wgs.show', $wg->wg_id)
            ->with('success', 'WG aktiviert.');
    }
}
