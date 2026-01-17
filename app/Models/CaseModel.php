<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaseModel extends Model
{
    use HasUuids;

    protected $table = 'cases';
    protected $primaryKey = 'case_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'wg_id','created_by_user_id','case_title','status','problem_description','priority',
        'required_docs','next_actions','deadlines','source_links','attachments','last_reviewed_at',
        'issue_categories','authority_targets','owner',
    ];

    protected $casts = [
        'last_reviewed_at' => 'datetime',
    ];

    /**
     * Get the route key name for Laravel route model binding.
     */
    public function getRouteKeyName()
    {
        return 'case_id';
    }

    public function wg(): BelongsTo
    {
        return $this->belongsTo(Wg::class, 'wg_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function issues(): BelongsToMany
    {
        return $this->belongsToMany(Issue::class, 'case_issue', 'case_id', 'issue_id')->withTimestamps();
    }

    public function authorities(): BelongsToMany
    {
        return $this->belongsToMany(Authority::class, 'case_authority', 'case_id', 'authority_id')->withTimestamps();
    }

    public function evidence(): HasMany
    {
        return $this->hasMany(SourceEvidence::class, 'case_id');
    }
}
