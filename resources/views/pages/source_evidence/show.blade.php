<x-layouts::app :title="$evidence->title ?? 'Quellenbeleg'">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">
                        {{ $evidence->title ?? 'Quellenbeleg' }}
                    </h1>
                    <a href="{{ $evidence->url }}" target="_blank"
                        class="text-blue-600 dark:text-blue-400 hover:underline break-all text-sm">
                        {{ $evidence->domain ?? $evidence->url }}
                    </a>
                </div>
                <div class="flex gap-2 flex-wrap justify-end">
                    <a href="{{ route('source-evidence.edit', $evidence->id) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 font-medium transition-colors">
                        Bearbeiten
                    </a>
                    <a href="{{ route('source-evidence.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-neutral-600 hover:bg-neutral-700 text-white px-4 py-2 font-medium transition-colors">
                        Zurück
                    </a>
                </div>
            </div>
        </div>

        <!-- Score Badges -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @if($evidence->total_score)
                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $evidence->total_score }}
                        </div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">Gesamtscore</div>
                    </div>
                </div>
            @endif
            @if($evidence->authority_score)
                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $evidence->authority_score }}
                        </div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">Autorität</div>
                    </div>
                </div>
            @endif
            @if($evidence->relevance_score)
                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $evidence->relevance_score }}
                        </div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">Relevanz</div>
                    </div>
                </div>
            @endif
            @if($evidence->jurisdiction_score)
                <div class="rounded-xl border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $evidence->jurisdiction_score }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">Jurisdiktion</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Source Info -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Quelleninformationen</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Quelltyp</dt>
                        <dd class="text-neutral-900 dark:text-white">{{ $evidence->source_type ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Jurisdiktionsbereich</dt>
                        <dd class="text-neutral-900 dark:text-white">{{ $evidence->jurisdiction_scope ?? '—' }}</dd>
                    </div>
                    @if($evidence->selected)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Status</dt>
                            <dd>
                                <span
                                    class="inline-flex rounded-full bg-green-100 dark:bg-green-900/30 px-3 py-1 text-sm text-green-700 dark:text-green-100">
                                    Vom Nutzer ausgewählt
                                </span>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Related Entities -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Verknüpfungen</h2>
                <dl class="space-y-3">
                    @if($evidence->case)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Fall</dt>
                            <dd>
                                <a href="{{ route('cases.show', $evidence->case->case_id) }}"
                                    class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $evidence->case->case_title }}
                                </a>
                            </dd>
                        </div>
                    @endif
                    @if($evidence->issue)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Problem</dt>
                            <dd>
                                <a href="{{ route('issues.show', $evidence->issue->id) }}"
                                    class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $evidence->issue->name }}
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Excerpt -->
            @if($evidence->evidence_excerpt)
                <div
                    class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900 lg:col-span-2">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Auszug</h2>
                    <p class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $evidence->evidence_excerpt }}</p>
                </div>
            @endif

            <!-- Claim Supported -->
            @if($evidence->claim_supported)
                <div
                    class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900 lg:col-span-2">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Behauptung unterstützt durch</h2>
                    <p class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $evidence->claim_supported }}</p>
                </div>
            @endif

            <!-- Metadata -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Informationen</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Erstellt am</dt>
                        <dd class="text-neutral-900 dark:text-white">{{ $evidence->created_at->format('d.m.Y H:i') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Zuletzt aktualisiert</dt>
                        <dd class="text-neutral-900 dark:text-white">{{ $evidence->updated_at->format('d.m.Y H:i') }}
                        </dd>
                    </div>
                    @if($evidence->checked_at)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Zuletzt überprüft</dt>
                            <dd class="text-neutral-900 dark:text-white">{{ $evidence->checked_at->format('d.m.Y H:i') }}
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="rounded-xl border border-red-200 bg-red-50 p-6 dark:border-red-900 dark:bg-red-950">
            <h2 class="text-lg font-bold text-red-900 dark:text-red-200 mb-4">Gefahr-Zone</h2>
            <form method="POST" action="{{ route('source-evidence.destroy', $evidence->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                    onclick="return confirm('Sind Sie sicher, dass Sie diesen Quellenbeleg löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.')"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    Quellenbeleg löschen
                </button>
            </form>
        </div>
    </div>
</x-layouts::app>