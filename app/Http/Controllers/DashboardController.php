<?php

namespace App\Http\Controllers;

use App\Models\Wg;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Alle WGs des Users (für Dropdown/Auswahl)
        $wgs = Wg::where('owner_user_id', $user->id)->get();
        
        // Aktive WG (oder letzte)
        $wg = $user->activeWg ?? $wgs->first();
        
        $baseFormUrl = config('services.n8n.form_url');
        $formUrl = $wg ? $baseFormUrl . '?wg_id=' . $wg->wg_id : $baseFormUrl;
        
        return view('dashboard', [
            'wgs' => $wgs,        // ← Alle WGs zum Auswählen
            'wg' => $wg,          // ← Aktuell ausgewählte
            'formUrl' => $formUrl,
            'chatWebhookUrl' => config('services.n8n.chat_url'),
        ]);
    }
}
