<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IssueController extends Controller
{
    /**
     * Display a listing of issues.
     */
    public function index(): View
    {
        $issues = Issue::latest()->get();

        return view('pages.tables.issues', [
            'issues' => $issues,
        ]);
    }

    /**
     * Show the form for creating a new issue.
     */
    public function create(): View
    {
        return view('pages.issues.create');
    }

    /**
     * Store a newly created issue in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:issues,code'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'default_authority_targets' => ['nullable', 'string'],
            'default_required_docs' => ['nullable', 'string'],
            'default_next_actions' => ['nullable', 'string'],
            'default_source_links' => ['nullable', 'string'],
            'rule_hints' => ['nullable', 'string'],
        ]);

        $issue = Issue::create([
            'id' => Str::uuid(),
            ...$validated,
        ]);

        return redirect()->route('issues.show', $issue->id)
            ->with('success', 'Problem erfolgreich erstellt.');
    }

    /**
     * Display the specified issue.
     */
    public function show(Issue $issue): View
    {
        return view('pages.issues.show', [
            'issue' => $issue,
        ]);
    }

    /**
     * Show the form for editing the specified issue.
     */
    public function edit(Issue $issue): View
    {
        return view('pages.issues.edit', [
            'issue' => $issue,
        ]);
    }

    /**
     * Update the specified issue in storage.
     */
    public function update(Request $request, Issue $issue): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:issues,code,' . $issue->id],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'default_authority_targets' => ['nullable', 'string'],
            'default_required_docs' => ['nullable', 'string'],
            'default_next_actions' => ['nullable', 'string'],
            'default_source_links' => ['nullable', 'string'],
            'rule_hints' => ['nullable', 'string'],
        ]);

        $issue->update($validated);

        return redirect()->route('issues.show', $issue->id)
            ->with('success', 'Problem aktualisiert.');
    }

    /**
     * Delete the specified issue.
     */
    public function destroy(Issue $issue): RedirectResponse
    {
        $issue->delete();

        return redirect()->route('issues.index')
            ->with('success', 'Problem gelöscht.');
    }
}
