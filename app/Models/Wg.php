<?php

namespace App\Models;

use App\Enums\GermanState;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wg extends Model
{
    use HasUuids;

    protected $table = 'wgs';
    protected $primaryKey = 'wg_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'owner_user_id','wg_name','address_text','state','district','municipality',
        'governance','residents_total','residents_with_pg','target_group',
        'has_24h_presence','has_presence_staff','care_provider_mode',
        'lease_individual','care_individual','bundle_housing_care',
        'sgb_xi_used','sgb_xii_involved','sgb_v_hkp',
        'landesrecht_title','landesrecht_url','heimaufsicht_contact_hint','notes',
    ];

    protected $casts = [
        'state' => GermanState::class,
        'has_24h_presence' => 'boolean',
        'has_presence_staff' => 'boolean',
        'lease_individual' => 'boolean',
        'care_individual' => 'boolean',
        'bundle_housing_care' => 'boolean',
        'sgb_xi_used' => 'boolean',
        'sgb_xii_involved' => 'boolean',
        'sgb_v_hkp' => 'boolean',
    ];

    /**
     * Get the route key name for Laravel route model binding.
     */
    public function getRouteKeyName()
    {
        return 'wg_id';
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function cases(): HasMany
    {
        return $this->hasMany(CaseModel::class, 'wg_id');
    }
}
