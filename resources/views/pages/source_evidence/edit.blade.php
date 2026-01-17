<x-layouts::app :title="__('Quellenbeleg bearbeiten')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Quellenbeleg bearbeiten</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">{{ $evidence->title ?? 'Quellenbeleg' }}</p>
                </div>
                <a href="{{ route('source-evidence.show', $evidence->id) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-neutral-600 hover:bg-neutral-700 text-white px-4 py-2 font-medium transition-colors">
                    Abbrechen
                </a>
            </div>
        </div>

        <!-- Form -->
        <div
            class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900 max-w-2xl">
            <form method="POST" action="{{ route('source-evidence.update', $evidence->id) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Case ID -->
                <div>
                    <label for="case_id" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Fall *
                    </label>
                    <input type="text" id="case_id" name="case_id" value="{{ old('case_id', $evidence->case_id) }}"
                        required
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono"
                        placeholder="UUID des Falls" />
                    @error('case_id')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- URL -->
                <div>
                    <label for="url" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        URL *
                    </label>
                    <input type="url" id="url" name="url" value="{{ old('url', $evidence->url) }}" required
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="https://example.com/law" />
                    @error('url')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Titel
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $evidence->title) }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. SGB XI - Pflegeversicherung" />
                </div>

                <!-- Domain -->
                <div>
                    <label for="domain" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Domain
                    </label>
                    <input type="text" id="domain" name="domain" value="{{ old('domain', $evidence->domain) }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. example.com" />
                </div>

                <!-- Source Type -->
                <div>
                    <label for="source_type" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Quelltyp
                    </label>
                    <input type="text" id="source_type" name="source_type"
                        value="{{ old('source_type', $evidence->source_type) }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. OFFICIAL, LAW, AUTHORITY" />
                </div>

                <!-- Jurisdiction Scope -->
                <div>
                    <label for="jurisdiction_scope"
                        class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Jurisdiktionsbereich
                    </label>
                    <input type="text" id="jurisdiction_scope" name="jurisdiction_scope"
                        value="{{ old('jurisdiction_scope', $evidence->jurisdiction_scope) }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. FEDERAL, STATE, EU" />
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="evidence_excerpt"
                        class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Auszug aus der Quelle
                    </label>
                    <textarea id="evidence_excerpt" name="evidence_excerpt" rows="4"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Relevanter Text aus der Quelle...">{{ old('evidence_excerpt', $evidence->evidence_excerpt) }}</textarea>
                </div>

                <!-- Claim Supported -->
                <div>
                    <label for="claim_supported"
                        class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Behauptung unterstützt
                    </label>
                    <textarea id="claim_supported" name="claim_supported" rows="2"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Was wird durch diese Quelle belegt?">{{ old('claim_supported', $evidence->claim_supported) }}</textarea>
                </div>

                <!-- Scores -->
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="authority_score"
                            class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                            Autorität (0-100)
                        </label>
                        <input type="number" id="authority_score" name="authority_score"
                            value="{{ old('authority_score', $evidence->authority_score) }}" min="0" max="100"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label for="relevance_score"
                            class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                            Relevanz (0-100)
                        </label>
                        <input type="number" id="relevance_score" name="relevance_score"
                            value="{{ old('relevance_score', $evidence->relevance_score) }}" min="0" max="100"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label for="jurisdiction_score"
                            class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                            Jurisdiktion (0-100)
                        </label>
                        <input type="number" id="jurisdiction_score" name="jurisdiction_score"
                            value="{{ old('jurisdiction_score', $evidence->jurisdiction_score) }}" min="0" max="100"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>

                <!-- Selected -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="selected" name="selected" value="1" {{ old('selected', $evidence->selected) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-neutral-300 text-blue-600 focus:ring-2 focus:ring-blue-500" />
                    <label for="selected" class="text-sm font-medium text-neutral-900 dark:text-white">
                        Vom Nutzer ausgewählt
                    </label>
                </div>

                <!-- Submit -->
                <div class="flex gap-3">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        Speichern
                    </button>
                    <a href="{{ route('source-evidence.show', $evidence->id) }}"
                        class="px-6 py-2 bg-neutral-600 hover:bg-neutral-700 text-white rounded-lg font-medium transition-colors">
                        Abbrechen
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>