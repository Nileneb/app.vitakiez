<?php

namespace App\Http\Controllers;

use App\Models\Wg;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $wg = $user->activeWg ?? Wg::where('owner_user_id', $user->id)->first();
        
        $baseFormUrl = config('services.n8n.form_url');
        $formUrl = $wg ? $baseFormUrl . '?wg_id=' . $wg->wg_id : $baseFormUrl;
        
        return view('dashboard', [
            'formUrl' => $formUrl,
            'chatWebhookUrl' => config('services.n8n.chat_url'),
        ]);
    }
}
