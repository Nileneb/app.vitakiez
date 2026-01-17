<x-layouts::app :title="__('Behörde bearbeiten: ' . $authority->name)">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Behörde bearbeiten</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">{{ $authority->name }}</p>
                </div>
                <a href="{{ route('authorities.show', $authority->id) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-neutral-600 hover:bg-neutral-700 text-white px-4 py-2 font-medium transition-colors">
                    Abbrechen
                </a>
            </div>
        </div>

        <!-- Form -->
        <div
            class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900 max-w-2xl">
            <form method="POST" action="{{ route('authorities.update', $authority->id) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Name *
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $authority->name) }}" required
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. Heimaufsicht Nordrhein-Westfalen" />
                    @error('name')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="authority_type" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Behördentyp
                    </label>
                    <input type="text" id="authority_type" name="authority_type"
                        value="{{ old('authority_type', $authority->authority_type) }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. Heimaufsicht, Behörde, Gericht" />
                </div>

                <!-- Jurisdiction State -->
                <div>
                    <label for="jurisdiction_state"
                        class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Bundesland
                    </label>
                    <input type="text" id="jurisdiction_state" name="jurisdiction_state"
                        value="{{ old('jurisdiction_state', $authority->jurisdiction_state) }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="z.B. NRW" />
                </div>

                <!-- Jurisdiction District & Municipality -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="jurisdiction_district"
                            class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                            Kreis/Bezirk
                        </label>
                        <input type="text" id="jurisdiction_district" name="jurisdiction_district"
                            value="{{ old('jurisdiction_district', $authority->jurisdiction_district) }}"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label for="jurisdiction_municipality"
                            class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                            Gemeinde
                        </label>
                        <input type="text" id="jurisdiction_municipality" name="jurisdiction_municipality"
                            value="{{ old('jurisdiction_municipality', $authority->jurisdiction_municipality) }}"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>

                <!-- Contact Info -->
                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        E-Mail
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $authority->email) }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="kontakt@behoerde.de" />
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Telefon
                    </label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $authority->phone) }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="+49 201 234567" />
                </div>

                <div>
                    <label for="address_text" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Adresse
                    </label>
                    <input type="text" id="address_text" name="address_text"
                        value="{{ old('address_text', $authority->address_text) }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Straße 42, 45326 Essen" />
                </div>

                <div>
                    <label for="website_url" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Website
                    </label>
                    <input type="url" id="website_url" name="website_url"
                        value="{{ old('website_url', $authority->website_url) }}"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="https://www.behoerde.de" />
                </div>

                <!-- Office Hours & Notes -->
                <div>
                    <label for="office_hours" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Öffnungszeiten
                    </label>
                    <textarea id="office_hours" name="office_hours" rows="2"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Mo-Fr: 09:00-17:00 Uhr">{{ old('office_hours', $authority->office_hours) }}</textarea>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-neutral-900 dark:text-white mb-2">
                        Notizen
                    </label>
                    <textarea id="notes" name="notes" rows="2"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg dark:border-neutral-600 dark:bg-neutral-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Zusätzliche Informationen...">{{ old('notes', $authority->notes) }}</textarea>
                </div>

                <!-- Submit -->
                <div class="flex gap-3">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        Speichern
                    </button>
                    <a href="{{ route('authorities.show', $authority->id) }}"
                        class="px-6 py-2 bg-neutral-600 hover:bg-neutral-700 text-white rounded-lg font-medium transition-colors">
                        Abbrechen
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>