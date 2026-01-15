<?php

namespace App\Http\Controllers;

use App\Models\Wg;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get or create a WG for the user
        $wg = Wg::where('owner_user_id', $user->id)->first();
        
        if (!$wg) {
            // Create a new WG for the user
            $wg = Wg::create([
                'owner_user_id' => $user->id,
                'name' => 'Meine WG',
                'state' => '',
                'district' => '',
                'municipality' => '',
                'address_text' => '',
                'governance' => 'SELF_ORGANIZED',
                'residents_total' => 0,
                'residents_with_pg' => 0,
                'target_group' => '',
                'has_24h_presence' => false,
                'has_presence_staff' => false,
                'care_provider_mode' => 'NONE',
                'lease_individual' => false,
                'care_individual' => false,
                'bundle_housing_care' => false,
                'sgb_xi_used' => false,
            ]);
        }
        
        // n8n form URL with wg_id parameter
        $formUrl = 'https://n8n.linn.games/webhook/5dd82489-f71f-4c10-97aa-564fb844ec2d/n8n-form?wg_id=' . $wg->id;
        
        return view('dashboard', [
            'wg' => $wg,
            'formUrl' => $formUrl,
        ]);
    }
}
