<?php

namespace App\Http\Controllers;

use App\Models\CaseModel;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CaseController extends Controller
{
    /**
     * Display a listing of cases for the active WG.
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $activeWg = $user->activeWg;

        $cases = $activeWg ? $activeWg->cases()->with(['createdBy', 'issues'])->latest()->get() : collect();

        return view('pages.tables.cases', [
            'cases' => $cases,
        ]);
    }

    /**
     * Show the form for creating a new case.
     */
    public function create(): View
    {
        return view('pages.cases.create');
    }

    /**
     * Store a newly created case in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->active_wg_id) {
            return back()->withErrors(['wg_id' => 'Bitte wählen Sie zuerst eine WG aus.']);
        }

        $validated = $request->validate([
            'case_title' => ['required', 'string', 'max:255'],
            'problem_description' => ['required', 'string'],
            'status' => ['nullable', 'string', 'in:OPEN,IN_PROGRESS,WAITING,DONE,ARCHIVED'],
            'priority' => ['nullable', 'string', 'in:LOW,MEDIUM,HIGH,CRITICAL'],
            'required_docs' => ['nullable', 'string'],
            'next_actions' => ['nullable', 'string'],
            'deadlines' => ['nullable', 'string'],
            'source_links' => ['nullable', 'string'],
        ]);

        $case = CaseModel::create([
            'case_id' => Str::uuid(),
            'wg_id' => $user->active_wg_id,
            'created_by_user_id' => $user->id,
            'status' => $validated['status'] ?? 'OPEN',
            'priority' => $validated['priority'] ?? 'MEDIUM',
            ...$validated,
        ]);

        return redirect()->route('cases.show', $case->case_id)
            ->with('success', 'Fall erfolgreich erstellt.');
    }

    /**
     * Display the specified case.
     */
    public function show(CaseModel $case): View
    {
        $this->authorize('view', $case);

        $case->load(['wg', 'createdBy', 'issues', 'authorities', 'evidence']);

        return view('pages.cases.show', [
            'case' => $case,
        ]);
    }

    /**
     * Show the form for editing the specified case.
     */
    public function edit(CaseModel $case): View
    {
        $this->authorize('update', $case);

        return view('pages.cases.edit', [
            'case' => $case,
        ]);
    }

    /**
     * Update the specified case in storage.
     */
    public function update(Request $request, CaseModel $case): RedirectResponse
    {
        $this->authorize('update', $case);

        $validated = $request->validate([
            'case_title' => ['required', 'string', 'max:255'],
            'problem_description' => ['required', 'string'],
            'status' => ['nullable', 'string', 'in:OPEN,IN_PROGRESS,WAITING,DONE,ARCHIVED'],
            'priority' => ['nullable', 'string', 'in:LOW,MEDIUM,HIGH,CRITICAL'],
            'required_docs' => ['nullable', 'string'],
            'next_actions' => ['nullable', 'string'],
            'deadlines' => ['nullable', 'string'],
            'source_links' => ['nullable', 'string'],
        ]);

        $case->update($validated);

        return redirect()->route('cases.show', $case->case_id)
            ->with('success', 'Fall aktualisiert.');
    }

    /**
     * Delete the specified case.
     */
    public function destroy(CaseModel $case): RedirectResponse
    {
        $this->authorize('delete', $case);

        $case->delete();

        return redirect()->route('cases.index')
            ->with('success', 'Fall gelöscht.');
    }
}
