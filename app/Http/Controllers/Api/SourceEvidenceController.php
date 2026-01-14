<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaseModel;
use App\Models\Issue;
use App\Models\SourceEvidence;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SourceEvidenceController extends Controller
{
    public function bulkUpsert(Request $request, CaseModel $case)
    {
        $user = $request->user();

        // Ensure ownership via WG
        if ($case->wg->owner_user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'items' => ['required','array','min:1','max:50'],
            'items.*.issue_code' => ['nullable','string','max:64'],
            'items.*.url' => ['required','string','max:2048'],
            'items.*.domain' => ['nullable','string','max:255'],
            'items.*.title' => ['nullable','string'],
            'items.*.source_type' => ['nullable','in:OFFICIAL,LAW,AUTHORITY,INSURER,CONSUMER,ASSOCIATION,OTHER'],
            'items.*.jurisdiction_scope' => ['nullable','in:FEDERAL,STATE,EU,MUNICIPAL,OTHER'],
            'items.*.evidence_excerpt' => ['nullable','string'],
            'items.*.claim_supported' => ['nullable','string'],
            'items.*.authority_score' => ['nullable','integer','min:0','max:10'],
            'items.*.relevance_score' => ['nullable','integer','min:0','max:10'],
            'items.*.jurisdiction_score' => ['nullable','integer','min:0','max:10'],
            'items.*.total_score' => ['nullable','integer','min:0','max:30'],
            'items.*.http_status' => ['nullable','integer','min:0','max:999'],
            'items.*.selected' => ['nullable','boolean'],
            'items.*.text_full' => ['nullable','string'],
            'items.*.text_path' => ['nullable','string','max:2048'],
            'items.*.content_hash' => ['nullable','string','max:128'],
        ]);

        $out = [];
        foreach ($data['items'] as $it) {
            $issueId = null;
            if (!empty($it['issue_code'])) {
                $issueId = Issue::where('code', $it['issue_code'])->value('id');
            }

            $record = SourceEvidence::updateOrCreate(
                ['case_id' => $case->id, 'url' => $it['url']],
                [
                    'issue_id' => $issueId,
                    'domain' => $it['domain'] ?? parse_url($it['url'], PHP_URL_HOST),
                    'title' => $it['title'] ?? null,
                    'source_type' => $it['source_type'] ?? 'OTHER',
                    'jurisdiction_scope' => $it['jurisdiction_scope'] ?? 'OTHER',
                    'evidence_excerpt' => $it['evidence_excerpt'] ?? null,
                    'claim_supported' => $it['claim_supported'] ?? null,
                    'authority_score' => $it['authority_score'] ?? 0,
                    'relevance_score' => $it['relevance_score'] ?? 0,
                    'jurisdiction_score' => $it['jurisdiction_score'] ?? 0,
                    'total_score' => $it['total_score'] ?? 0,
                    'http_status' => $it['http_status'] ?? null,
                    'checked_at' => now(),
                    'selected' => $it['selected'] ?? false,
                    'text_full' => $it['text_full'] ?? null,
                    'text_path' => $it['text_path'] ?? null,
                    'content_hash' => $it['content_hash'] ?? null,
                ]
            );

            $out[] = $record;
        }

        return response()->json(['count' => count($out)], 200);
    }
}
