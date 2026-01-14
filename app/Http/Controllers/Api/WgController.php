<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wg;
use Illuminate\Http\Request;

class WgController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return Wg::where('owner_user_id', $user->id)->orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'state' => ['required','string','max:255'],
            'district' => ['nullable','string','max:255'],
            'municipality' => ['nullable','string','max:255'],
            'address_text' => ['nullable','string','max:255'],

            'governance' => ['nullable','in:SELF_ORGANIZED,PROVIDER_ORGANIZED,MIXED,UNKNOWN'],
            'residents_total' => ['nullable','integer','min:0','max:99'],
            'residents_with_pg' => ['nullable','integer','min:0','max:99'],
            'target_group' => ['nullable','string','max:255'],

            'has_24h_presence' => ['nullable','boolean'],
            'has_presence_staff' => ['nullable','boolean'],

            'care_provider_mode' => ['nullable','in:FREE_CHOICE,SINGLE_PROVIDER,INHOUSE,MIXED,UNKNOWN'],

            'lease_individual' => ['nullable','boolean'],
            'care_individual' => ['nullable','boolean'],
            'bundle_housing_care' => ['nullable','boolean'],

            'sgb_xi_used' => ['nullable','boolean'],
            'sgb_xii_involved' => ['nullable','boolean'],
            'sgb_v_hkp' => ['nullable','boolean'],

            'landesrecht_title' => ['nullable','string','max:255'],
            'landesrecht_url' => ['nullable','string','max:2048'],
            'heimaufsicht_contact_hint' => ['nullable','string','max:255'],
            'notes' => ['nullable','string'],
        ]);

        $wg = Wg::create(array_merge($data, [
            'owner_user_id' => $user->id,
            'governance' => $data['governance'] ?? 'UNKNOWN',
            'care_provider_mode' => $data['care_provider_mode'] ?? 'UNKNOWN',
        ]));

        // Optional: direkt aktiv setzen, wenn noch keine aktive WG existiert
        if (!$user->active_wg_id) {
            $user->active_wg_id = $wg->id;
            $user->save();
        }

        return response()->json($wg, 201);
    }

    public function getActive(Request $request)
    {
        $user = $request->user();
        if (!$user->active_wg_id) return response()->json(null);

        $wg = Wg::where('id', $user->active_wg_id)
            ->where('owner_user_id', $user->id)
            ->first();

        return response()->json($wg);
    }

    public function setActive(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'wg_id' => ['required','uuid'],
        ]);

        $wg = Wg::where('id', $data['wg_id'])
            ->where('owner_user_id', $user->id)
            ->firstOrFail();

        $user->active_wg_id = $wg->id;
        $user->save();

        return response()->json(['active_wg_id' => $wg->id]);
    }
}
