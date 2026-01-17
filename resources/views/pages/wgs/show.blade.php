<x-layouts::app :title="$wg->wg_name">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $wg->wg_name }}</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        {{ $wg->address_text ?? 'Keine Adresse angegeben' }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('wgs.edit', $wg->wg_id) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 font-medium transition-colors">
                        Bearbeiten
                    </a>
                    <a href="{{ route('wgs.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-neutral-600 hover:bg-neutral-700 text-white px-4 py-2 font-medium transition-colors">
                        Zurück
                    </a>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Basic Info -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold mb-4">Grundinformationen</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Name</label>
                        <p class="text-neutral-900 dark:text-white">{{ $wg->wg_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Adresse</label>
                        <p class="text-neutral-900 dark:text-white">{{ $wg->address_text ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Bundesland</label>
                        <p class="text-neutral-900 dark:text-white">{{ $wg->state ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Bezirk/Kreis</label>
                        <p class="text-neutral-900 dark:text-white">{{ $wg->district ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Gemeinde</label>
                        <p class="text-neutral-900 dark:text-white">{{ $wg->municipality ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Residents -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold mb-4">Bewohner</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Gesamtanzahl</label>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $wg->residents_total ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Mit
                            Pflegebedarf</label>
                        <p class="text-2xl font-bold text-blue-600">{{ $wg->residents_with_pg ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Zielgruppe</label>
                        <p class="text-neutral-900 dark:text-white">{{ $wg->target_group ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold mb-4">Leistungen</h2>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        @if($wg->has_24h_presence)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-100">✓
                                24h Präsenz</span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700 dark:bg-neutral-800 dark:text-neutral-400">Keine
                                24h Präsenz</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @if($wg->has_presence_staff)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-100">✓
                                Personal vor Ort</span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-neutral-100 px-2 py-1 text-xs font-medium text-neutral-700 dark:bg-neutral-800 dark:text-neutral-400">Kein
                                Personal vor Ort</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @if($wg->bundle_housing_care)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-100">✓
                                Wohnen + Pflege</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Governance -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-semibold mb-4">Trägerschaft & Finanzierung</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Trägerform</label>
                        <p class="text-neutral-900 dark:text-white">{{ match ($wg->governance ?? '') {
    'SELF_ORGANIZED' => 'Selbstorganisiert',
    'PROVIDER_MANAGED' => 'Träger verwaltet',
    default => $wg->governance ?? '-'
} }}</p>
                    </div>
                    <div>
                        <label
                            class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Versorgungsmodell</label>
                        <p class="text-neutral-900 dark:text-white">{{ match ($wg->care_provider_mode ?? '') {
    'INDEPENDENT' => 'Unabhängig',
    'PROVIDER' => 'Träger',
    'MIXED' => 'Gemischt',
    default => $wg->care_provider_mode ?? '-'
} }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="rounded-xl border border-red-200 bg-red-50 p-6 dark:border-red-900 dark:bg-red-900/20">
            <h2 class="text-lg font-semibold text-red-900 dark:text-red-100 mb-4">Gefahrenzone</h2>
            <form method="POST" action="{{ route('wgs.destroy', $wg->wg_id) }}"
                onsubmit="return confirm('Diese WG wirklich löschen? Alle Daten werden gelöscht.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    WG löschen
                </button>
            </form>
        </div>
    </div>
</x-layouts::app>