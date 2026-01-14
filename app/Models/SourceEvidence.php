<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SourceEvidence extends Model
{
    use HasUuids;

    protected $table = 'source_evidence';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'case_id','issue_id','url','domain','source_type','jurisdiction_scope','title',
        'evidence_excerpt','claim_supported',
        'authority_score','relevance_score','jurisdiction_score','total_score',
        'http_status','checked_at','selected',
        'text_full','text_path','content_hash'
    ];

    protected $casts = [
        'selected' => 'boolean',
        'checked_at' => 'datetime',
    ];

    public function case(): BelongsTo
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }

    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }
}
