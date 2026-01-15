<?php

namespace App\Http\Controllers;

use App\Models\Wg;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Only fetch an existing WG; do NOT pre-create before the form is submitted
        $wg = Wg::where('owner_user_id', $user->id)->latest()->first();
        
        // n8n form URL; append wg_id only if one exists (creation happens after form submission)
        $baseFormUrl = 'https://n8n.linn.games/webhook/5dd82489-f71f-4c10-97aa-564fb844ec2d/n8n-form';
        $formUrl = $wg ? $baseFormUrl . '?wg_id=' . $wg->wg_id : $baseFormUrl;
        
        return view('dashboard', [
            'wg' => $wg,
            'formUrl' => $formUrl,
        ]);
    }
}
