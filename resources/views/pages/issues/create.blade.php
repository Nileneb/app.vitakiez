<x-layouts::app :title="__('Neues Problem erstellen')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Neues Problem erstellen</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">Fügen Sie ein neues Problem zum Katalog hinzu</p>
                </div>
                <a href="{{ route('issues.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-neutral-600 hover:bg-neutral-700 text-white px-4 py-2 font-medium transition-colors">
                    Abbrechen
                </a>
            </div>
        </div>

        <!-- Form -->
        <div
            class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900 max-w-2xl">
            <form method="POST" action="{{ route('issues.store') }}" class="space-y-6">
                @csrf

                <!-- Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Code *
                    </label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono"
                        placeholder="z.B. HOUSING_38A" />
                    @error('code')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Name *
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. Wohnraum § 38a SGB XI" />
                    @error('name')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Beschreibung
                    </label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Detaillierte Beschreibung des Problems...">{{ old('description') }}</textarea>
                </div>

                <!-- Default Authority Targets -->
                <div>
                    <label for="default_authority_targets"
                        class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Standard Behördenziele
                    </label>
                    <textarea id="default_authority_targets" name="default_authority_targets" rows="2"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Welche Behörden sind typischerweise zuständig?">{{ old('default_authority_targets') }}</textarea>
                </div>

                <!-- Default Required Docs -->
                <div>
                    <label for="default_required_docs"
                        class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Standard erforderliche Dokumente
                    </label>
                    <textarea id="default_required_docs" name="default_required_docs" rows="2"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Welche Dokumente werden typischerweise benötigt?">{{ old('default_required_docs') }}</textarea>
                </div>

                <!-- Default Next Actions -->
                <div>
                    <label for="default_next_actions"
                        class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Standard Nächste Schritte
                    </label>
                    <textarea id="default_next_actions" name="default_next_actions" rows="2"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Typische Handlungsschritte...">{{ old('default_next_actions') }}</textarea>
                </div>

                <!-- Rule Hints -->
                <div>
                    <label for="rule_hints" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Regel-Tipps
                    </label>
                    <textarea id="rule_hints" name="rule_hints" rows="2"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Wichtige Hinweise und Regeln...">{{ old('rule_hints') }}</textarea>
                </div>

                <!-- Submit -->
                <div class="flex gap-3">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        Problem erstellen
                    </button>
                    <a href="{{ route('issues.index') }}"
                        class="px-6 py-2 bg-neutral-600 hover:bg-neutral-700 text-white rounded-lg font-medium transition-colors">
                        Abbrechen
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>