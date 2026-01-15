<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaseModel;
use App\Models\Issue;
use App\Models\Authority;
use App\Models\Wg;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'wg_id' => ['nullable','uuid'],
            'case_title' => ['sometimes','string','max:255'],
            'title' => ['sometimes','string','max:255'],
            'problem_description' => ['required','string'],
            'priority' => ['nullable','in:LOW,MEDIUM,HIGH,CRITICAL'],
            'status' => ['nullable','in:OPEN,IN_PROGRESS,WAITING,DONE,ARCHIVED'],

            // normalized inputs from n8n/agent
            'issue_codes' => ['nullable','array','max:5'],
            'issue_codes.*' => ['string','max:64'],

            'authority_ids' => ['nullable','array','max:20'],
            'authority_ids.*' => ['uuid'],

            // transitional strings (optional)
            'required_docs' => ['nullable','string'],
            'next_actions' => ['nullable','string'],
            'deadlines' => ['nullable','string'],
            'source_links' => ['nullable','string'],
            'attachments' => ['nullable','string'],
        ]);

        // WG resolution: explicit wg_id OR user.active_wg_id
        $wgId = $data['wg_id'] ?? $user->active_wg_id;
        if (!$wgId) return response()->json(['message' => 'No wg_id provided and no active WG set'], 422);

        $wg = Wg::where('wg_id', $wgId)->where('owner_user_id', $user->id)->firstOrFail();

        // Normalize: prefer case_title, fallback to title
        $caseTitle = $request->input('case_title') ?? $request->input('title');
        if (!$caseTitle) {
            return response()->json([
                'message' => 'The case_title field is required.',
                'errors' => ['case_title' => ['The case_title field is required.']],
            ], 422);
        }

        $case = CaseModel::create([
            'wg_id' => $wg->wg_id,
            'created_by_user_id' => $user->id,
            'case_title' => $caseTitle,
            'problem_description' => $data['problem_description'],
            'priority' => $data['priority'] ?? 'MEDIUM',
            'status' => $data['status'] ?? 'OPEN',
            'required_docs' => $data['required_docs'] ?? null,
            'next_actions' => $data['next_actions'] ?? null,
            'deadlines' => $data['deadlines'] ?? null,
            'source_links' => $data['source_links'] ?? null,
            'attachments' => $data['attachments'] ?? null,
            'last_reviewed_at' => now(),
        ]);

        // Attach issues by code
        if (!empty($data['issue_codes'])) {
            $issueIds = Issue::whereIn('code', $data['issue_codes'])->pluck('id')->all();
            if ($issueIds) $case->issues()->sync($issueIds);
        }

        // Attach authorities by ids
        if (!empty($data['authority_ids'])) {
            $authIds = Authority::whereIn('id', $data['authority_ids'])->pluck('id')->all();
            if ($authIds) $case->authorities()->sync($authIds);
        }

        return response()->json($case->load(['issues','authorities']), 201);
    }
}
