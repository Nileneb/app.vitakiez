<?php

namespace App\Http\Controllers;

use App\Models\SourceEvidence;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SourceEvidenceController extends Controller
{
    /**
     * Display a listing of source evidence.
     */
    public function index(): View
    {
        $evidence = SourceEvidence::with(['case', 'issue'])->latest()->get();

        return view('pages.tables.source_evidence', [
            'evidence' => $evidence,
        ]);
    }

    /**
     * Show the form for creating new source evidence.
     */
    public function create(): View
    {
        return view('pages.source_evidence.create');
    }

    /**
     * Store newly created source evidence in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'case_id' => ['required', 'uuid', 'exists:cases,case_id'],
            'issue_id' => ['nullable', 'uuid', 'exists:issues,id'],
            'url' => ['required', 'url'],
            'domain' => ['nullable', 'string', 'max:255'],
            'source_type' => ['nullable', 'string', 'max:50'],
            'jurisdiction_scope' => ['nullable', 'string', 'max:50'],
            'title' => ['nullable', 'string'],
            'evidence_excerpt' => ['nullable', 'string'],
            'claim_supported' => ['nullable', 'string'],
            'authority_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'relevance_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'jurisdiction_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'total_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'selected' => ['nullable', 'boolean'],
        ]);

        $evidence = SourceEvidence::create([
            'id' => Str::uuid(),
            ...$validated,
        ]);

        return redirect()->route('source-evidence.show', $evidence->id)
            ->with('success', 'Quellenbeleg erfolgreich erstellt.');
    }

    /**
     * Display the specified source evidence.
     */
    public function show(SourceEvidence $sourceEvidence): View
    {
        $sourceEvidence->load(['case', 'issue']);

        return view('pages.source_evidence.show', [
            'evidence' => $sourceEvidence,
        ]);
    }

    /**
     * Show the form for editing the specified source evidence.
     */
    public function edit(SourceEvidence $sourceEvidence): View
    {
        return view('pages.source_evidence.edit', [
            'evidence' => $sourceEvidence,
        ]);
    }

    /**
     * Update the specified source evidence in storage.
     */
    public function update(Request $request, SourceEvidence $sourceEvidence): RedirectResponse
    {
        $validated = $request->validate([
            'case_id' => ['required', 'uuid', 'exists:cases,case_id'],
            'issue_id' => ['nullable', 'uuid', 'exists:issues,id'],
            'url' => ['required', 'url'],
            'domain' => ['nullable', 'string', 'max:255'],
            'source_type' => ['nullable', 'string', 'max:50'],
            'jurisdiction_scope' => ['nullable', 'string', 'max:50'],
            'title' => ['nullable', 'string'],
            'evidence_excerpt' => ['nullable', 'string'],
            'claim_supported' => ['nullable', 'string'],
            'authority_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'relevance_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'jurisdiction_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'total_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'selected' => ['nullable', 'boolean'],
        ]);

        $sourceEvidence->update($validated);

        return redirect()->route('source-evidence.show', $sourceEvidence->id)
            ->with('success', 'Quellenbeleg aktualisiert.');
    }

    /**
     * Delete the specified source evidence.
     */
    public function destroy(SourceEvidence $sourceEvidence): RedirectResponse
    {
        $sourceEvidence->delete();

        return redirect()->route('source-evidence.index')
            ->with('success', 'Quellenbeleg gelöscht.');
    }
}
