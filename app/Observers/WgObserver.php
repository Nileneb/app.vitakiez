<?php

namespace App\Observers;

use App\Models\Wg;
use Illuminate\Support\Str;

class WgObserver
{
    public function created(Wg $wg): void
    {
        // Generate per-user API key on first WG creation (for audit/logging purposes)
        $owner = $wg->owner;
        if ($owner && !$owner->n8n_api_key) {
            $owner->n8n_api_key = Str::random(40);
            $owner->save();
        }
    }
}
