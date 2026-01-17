<x-layouts::app :title="__('Neue WG erstellen')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Neue WG erstellen</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">Registrieren Sie eine neue Pflege-WG</p>
                </div>
                <a href="{{ route('wgs.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-neutral-600 hover:bg-neutral-700 text-white px-4 py-2 font-medium transition-colors">
                    Abbrechen
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900 max-w-2xl">
            <form method="POST" action="{{ route('wgs.store') }}" class="space-y-6">
                @csrf

                <!-- WG Name -->
                <div>
                    <label for="wg_name" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Name der WG *
                    </label>
                    <input
                        type="text"
                        id="wg_name"
                        name="wg_name"
                        value="{{ old('wg_name') }}"
                        required
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. Pflege-WG Linn"
                    />
                    @error('wg_name')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address_text" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Adresse
                    </label>
                    <input
                        type="text"
                        id="address_text"
                        name="address_text"
                        value="{{ old('address_text') }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. Kölnstraße 42, 50733 Köln"
                    />
                </div>

                <!-- State -->
                <div>
                    <label for="state" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Bundesland
                    </label>
                    <input
                        type="text"
                        id="state"
                        name="state"
                        value="{{ old('state') }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. NRW"
                    />
                </div>

                <!-- District -->
                <div>
                    <label for="district" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Kreis/Bezirk
                    </label>
                    <input
                        type="text"
                        id="district"
                        name="district"
                        value="{{ old('district') }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. Köln"
                    />
                </div>

                <!-- Municipality -->
                <div>
                    <label for="municipality" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Gemeinde
                    </label>
                    <input
                        type="text"
                        id="municipality"
                        name="municipality"
                        value="{{ old('municipality') }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <!-- Residents Total -->
                <div>
                    <label for="residents_total" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Gesamtanzahl Bewohner
                    </label>
                    <input
                        type="number"
                        id="residents_total"
                        name="residents_total"
                        value="{{ old('residents_total') }}"
                        min="1"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <!-- Residents with Care -->
                <div>
                    <label for="residents_with_pg" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Bewohner mit Pflegebedarf
                    </label>
                    <input
                        type="number"
                        id="residents_with_pg"
                        name="residents_with_pg"
                        value="{{ old('residents_with_pg') }}"
                        min="0"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <!-- Target Group -->
                <div>
                    <label for="target_group" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Zielgruppe
                    </label>
                    <input
                        type="text"
                        id="target_group"
                        name="target_group"
                        value="{{ old('target_group') }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. Senioren mit Pflegebedarf"
                    />
                </div>

                <!-- 24h Presence -->
                <div class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        id="has_24h_presence"
                        name="has_24h_presence"
                        value="1"
                        {{ old('has_24h_presence') ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-neutral-300 text-blue-600 focus:ring-2 focus:ring-blue-500"
                    />
                    <label for="has_24h_presence" class="text-sm font-medium text-neutral-900 dark:text-white">
                        24-Stunden Präsenz vorhanden
                    </label>
                </div>

                <!-- Staff on Site -->
                <div class="flex items-center gap-3">
                    <input
                        type="checkbox"
                        id="has_presence_staff"
                        name="has_presence_staff"
                        value="1"
                        {{ old('has_presence_staff') ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-neutral-300 text-blue-600 focus:ring-2 focus:ring-blue-500"
                    />
                    <label for="has_presence_staff" class="text-sm font-medium text-neutral-900 dark:text-white">
                        Betreuungspersonal vor Ort
                    </label>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Notizen
                    </label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="4"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Zusätzliche Informationen..."
                    >{{ old('notes') }}</textarea>
                </div>

                <!-- Submit -->
                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors"
                    >
                        WG erstellen
                    </button>
                    <a
                        href="{{ route('wgs.index') }}"
                        class="px-6 py-2 bg-neutral-600 hover:bg-neutral-700 text-white rounded-lg font-medium transition-colors"
                    >
                        Abbrechen
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
