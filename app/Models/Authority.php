<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Authority extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'authority_type','name','jurisdiction_state','jurisdiction_district','jurisdiction_municipality',
        'coverage_note','website_url','email','phone','address_text','office_hours','notes','last_verified_at'
    ];

    protected $casts = [
        'last_verified_at' => 'datetime',
    ];
}
