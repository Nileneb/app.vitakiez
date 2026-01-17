<x-layouts::app :title="$issue->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $issue->name }}</h1>
                        <span
                            class="inline-flex rounded-full bg-blue-100 dark:bg-blue-900/30 px-3 py-1 text-sm font-mono text-blue-700 dark:text-blue-100">
                            {{ $issue->code }}
                        </span>
                    </div>
                    @if($issue->description)
                        <p class="text-neutral-600 dark:text-neutral-400">{{ Str::limit($issue->description, 200) }}</p>
                    @endif
                </div>
                <div class="flex gap-2 flex-wrap justify-end">
                    <a href="{{ route('issues.edit', $issue->id) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 font-medium transition-colors">
                        Bearbeiten
                    </a>
                    <a href="{{ route('issues.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-neutral-600 hover:bg-neutral-700 text-white px-4 py-2 font-medium transition-colors">
                        Zurück
                    </a>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Full Description -->
            @if($issue->description)
                <div
                    class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900 lg:col-span-2">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Beschreibung</h2>
                    <p class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $issue->description }}</p>
                </div>
            @endif

            <!-- Authority Targets -->
            @if($issue->default_authority_targets)
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Behördenziele</h2>
                    <p class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $issue->default_authority_targets }}
                    </p>
                </div>
            @endif

            <!-- Required Docs -->
            @if($issue->default_required_docs)
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Erforderliche Dokumente</h2>
                    <p class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $issue->default_required_docs }}</p>
                </div>
            @endif

            <!-- Next Actions -->
            @if($issue->default_next_actions)
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Nächste Schritte</h2>
                    <p class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $issue->default_next_actions }}</p>
                </div>
            @endif

            <!-- Rule Hints -->
            @if($issue->rule_hints)
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Regel-Tipps</h2>
                    <p class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $issue->rule_hints }}</p>
                </div>
            @endif

            <!-- Metadata -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Informationen</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Erstellt am</dt>
                        <dd class="text-neutral-900 dark:text-white">{{ $issue->created_at->format('d.m.Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Zuletzt aktualisiert</dt>
                        <dd class="text-neutral-900 dark:text-white">{{ $issue->updated_at->format('d.m.Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="rounded-xl border border-red-200 bg-red-50 p-6 dark:border-red-900 dark:bg-red-950">
            <h2 class="text-lg font-bold text-red-900 dark:text-red-200 mb-4">Gefahr-Zone</h2>
            <form method="POST" action="{{ route('issues.destroy', $issue->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                    onclick="return confirm('Sind Sie sicher, dass Sie dieses Problem löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.')"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    Problem löschen
                </button>
            </form>
        </div>
    </div>
</x-layouts::app>