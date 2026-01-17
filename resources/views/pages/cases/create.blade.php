<x-layouts::app :title="__('Neuen Fall erstellen')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Neuen Fall erstellen</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">Dokumentieren Sie einen neuen Rechtsfall für Ihre
                        WG</p>
                </div>
                <a href="{{ route('cases.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-neutral-600 hover:bg-neutral-700 text-white px-4 py-2 font-medium transition-colors">
                    Abbrechen
                </a>
            </div>
        </div>

        <!-- Form -->
        <div
            class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900 max-w-3xl">
            <form method="POST" action="{{ route('cases.store') }}" class="space-y-6">
                @csrf

                <!-- Case Title -->
                <div>
                    <label for="case_title" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Fallbezeichnung *
                    </label>
                    <input type="text" id="case_title" name="case_title" value="{{ old('case_title') }}" required
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. Beschwerde Heimaufsicht wegen 24h-Präsenz" />
                    @error('case_title')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Problem Description -->
                <div>
                    <label for="problem_description"
                        class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Problembeschreibung *
                    </label>
                    <textarea id="problem_description" name="problem_description" rows="6" required
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Beschreiben Sie das Problem detailliert...">{{ old('problem_description') }}</textarea>
                    @error('problem_description')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status & Priority -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                            Status
                        </label>
                        <select id="status" name="status"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="OPEN" {{ old('status') == 'OPEN' ? 'selected' : '' }}>Offen</option>
                            <option value="IN_PROGRESS" {{ old('status') == 'IN_PROGRESS' ? 'selected' : '' }}>In
                                Bearbeitung</option>
                            <option value="WAITING" {{ old('status') == 'WAITING' ? 'selected' : '' }}>Wartend</option>
                            <option value="DONE" {{ old('status') == 'DONE' ? 'selected' : '' }}>Erledigt</option>
                            <option value="ARCHIVED" {{ old('status') == 'ARCHIVED' ? 'selected' : '' }}>Archiviert
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="priority" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                            Priorität
                        </label>
                        <select id="priority" name="priority"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="LOW" {{ old('priority') == 'LOW' ? 'selected' : '' }}>Niedrig</option>
                            <option value="MEDIUM" {{ old('priority') == 'MEDIUM' ? 'selected' : '' }}>Mittel</option>
                            <option value="HIGH" {{ old('priority') == 'HIGH' ? 'selected' : '' }}>Hoch</option>
                            <option value="CRITICAL" {{ old('priority') == 'CRITICAL' ? 'selected' : '' }}>Kritisch
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Next Actions -->
                <div>
                    <label for="next_actions" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Nächste Schritte
                    </label>
                    <textarea id="next_actions" name="next_actions" rows="3"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Welche Maßnahmen müssen ergriffen werden?">{{ old('next_actions') }}</textarea>
                </div>

                <!-- Required Docs -->
                <div>
                    <label for="required_docs" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Erforderliche Dokumente
                    </label>
                    <textarea id="required_docs" name="required_docs" rows="3"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Welche Dokumente werden benötigt?">{{ old('required_docs') }}</textarea>
                </div>

                <!-- Deadlines -->
                <div>
                    <label for="deadlines" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Fristen
                    </label>
                    <textarea id="deadlines" name="deadlines" rows="2"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Relevante Fristen...">{{ old('deadlines') }}</textarea>
                </div>

                <!-- Submit -->
                <div class="flex gap-3">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        Fall erstellen
                    </button>
                    <a href="{{ route('cases.index') }}"
                        class="px-6 py-2 bg-neutral-600 hover:bg-neutral-700 text-white rounded-lg font-medium transition-colors">
                        Abbrechen
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>