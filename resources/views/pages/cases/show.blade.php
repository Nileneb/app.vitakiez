<x-layouts::app :title="$case->case_title">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">
                        {{ $case->case_title }}
                    </h1>
                    <div class="flex gap-3 mt-3">
                        @php
                            $statusColors = [
                                'OPEN' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-100',
                                'IN_PROGRESS' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-100',
                                'WAITING' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-100',
                                'DONE' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-100',
                                'ARCHIVED' => 'bg-neutral-200 text-neutral-700 dark:bg-neutral-700 dark:text-neutral-300',
                            ];
                            $priorityColors = [
                                'LOW' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-100',
                                'MEDIUM' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-100',
                                'HIGH' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-100',
                                'CRITICAL' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-100',
                            ];
                        @endphp
                        <span
                            class="inline-flex rounded-full px-3 py-1 text-sm font-medium {{ $statusColors[$case->status] ?? $statusColors['OPEN'] }}">
                            {{ $case->status }}
                        </span>
                        <span
                            class="inline-flex rounded-full px-3 py-1 text-sm font-medium {{ $priorityColors[$case->priority] ?? $priorityColors['MEDIUM'] }}">
                            Priorität: {{ $case->priority }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-2 flex-wrap justify-end">
                    @can('update', $case)
                        <a href="{{ route('cases.edit', $case->case_id) }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 font-medium transition-colors">
                            Bearbeiten
                        </a>
                    @endcan
                    <a href="{{ route('cases.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-neutral-600 hover:bg-neutral-700 text-white px-4 py-2 font-medium transition-colors">
                        Zurück
                    </a>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Problem Description -->
            <div
                class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900 lg:col-span-2">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Problembeschreibung</h2>
                <p class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $case->problem_description }}</p>
            </div>

            <!-- Basic Info -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Basisinformationen</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">WG</dt>
                        <dd class="text-neutral-900 dark:text-white">{{ $case->wg->wg_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Erstellt von</dt>
                        <dd class="text-neutral-900 dark:text-white">{{ $case->createdBy->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Erstellt am</dt>
                        <dd class="text-neutral-900 dark:text-white">{{ $case->created_at->format('d.m.Y H:i') }}</dd>
                    </div>
                    @if($case->last_reviewed_at)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Zuletzt geprüft</dt>
                            <dd class="text-neutral-900 dark:text-white">{{ $case->last_reviewed_at->format('d.m.Y H:i') }}
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Actions & Docs -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Maßnahmen & Dokumente</h2>
                <dl class="space-y-3">
                    @if($case->next_actions)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Nächste Schritte</dt>
                            <dd class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $case->next_actions }}</dd>
                        </div>
                    @endif
                    @if($case->required_docs)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Erforderliche Dokumente
                            </dt>
                            <dd class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $case->required_docs }}</dd>
                        </div>
                    @endif
                    @if($case->deadlines)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Fristen</dt>
                            <dd class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $case->deadlines }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Issues -->
            @if($case->issues->count() > 0)
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Verknüpfte Probleme</h2>
                    <ul class="space-y-2">
                        @foreach($case->issues as $issue)
                            <li class="flex items-center gap-2">
                                <span
                                    class="inline-flex rounded bg-blue-100 dark:bg-blue-900/30 px-2 py-1 text-xs font-mono text-blue-700 dark:text-blue-100">{{ $issue->code }}</span>
                                <span class="text-neutral-900 dark:text-white">{{ $issue->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Authorities -->
            @if($case->authorities->count() > 0)
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Zuständige Behörden</h2>
                    <ul class="space-y-2">
                        @foreach($case->authorities as $authority)
                            <li class="text-neutral-900 dark:text-white">
                                {{ $authority->name }}
                                @if($authority->authority_type)
                                    <span
                                        class="text-sm text-neutral-600 dark:text-neutral-400">({{ $authority->authority_type }})</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Evidence -->
        @if($case->evidence->count() > 0)
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Quellenbelege
                    ({{ $case->evidence->count() }})</h2>
                <div class="space-y-3">
                    @foreach($case->evidence as $evidence)
                        <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-medium text-neutral-900 dark:text-white">
                                        {{ $evidence->title ?? 'Ohne Titel' }}</h3>
                                    <a href="{{ $evidence->url }}" target="_blank"
                                        class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $evidence->domain ?? $evidence->url }}
                                    </a>
                                </div>
                                @if($evidence->total_score)
                                    <span
                                        class="inline-flex rounded-full bg-green-100 dark:bg-green-900/30 px-3 py-1 text-sm font-medium text-green-700 dark:text-green-100">
                                        Score: {{ $evidence->total_score }}/100
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Danger Zone -->
        @can('delete', $case)
            <div class="rounded-xl border border-red-200 bg-red-50 p-6 dark:border-red-900 dark:bg-red-950">
                <h2 class="text-lg font-bold text-red-900 dark:text-red-200 mb-4">Gefahr-Zone</h2>
                <form method="POST" action="{{ route('cases.destroy', $case->case_id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Sind Sie sicher, dass Sie diesen Fall löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.')"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                        Fall löschen
                    </button>
                </form>
            </div>
        @endcan
    </div>
</x-layouts::app>