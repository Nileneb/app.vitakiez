<x-layouts::app :title="$authority->name">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">
                        {{ $authority->name }}
                    </h1>
                    @if($authority->authority_type)
                        <p class="text-neutral-600 dark:text-neutral-400">{{ $authority->authority_type }}</p>
                    @endif
                </div>
                <div class="flex gap-2 flex-wrap justify-end">
                    <a href="{{ route('authorities.edit', $authority->id) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 font-medium transition-colors">
                        Bearbeiten
                    </a>
                    <a href="{{ route('authorities.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-neutral-600 hover:bg-neutral-700 text-white px-4 py-2 font-medium transition-colors">
                        Zurück
                    </a>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Jurisdiction -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Zuständigkeit</h2>
                <dl class="space-y-3">
                    @if($authority->jurisdiction_state)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Bundesland</dt>
                            <dd class="text-neutral-900 dark:text-white">{{ $authority->jurisdiction_state }}</dd>
                        </div>
                    @endif
                    @if($authority->jurisdiction_district)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Kreis/Bezirk</dt>
                            <dd class="text-neutral-900 dark:text-white">{{ $authority->jurisdiction_district }}</dd>
                        </div>
                    @endif
                    @if($authority->jurisdiction_municipality)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Gemeinde</dt>
                            <dd class="text-neutral-900 dark:text-white">{{ $authority->jurisdiction_municipality }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Contact Info -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Kontakt</h2>
                <dl class="space-y-3">
                    @if($authority->email)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">E-Mail</dt>
                            <dd>
                                <a href="mailto:{{ $authority->email }}"
                                    class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $authority->email }}
                                </a>
                            </dd>
                        </div>
                    @endif
                    @if($authority->phone)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Telefon</dt>
                            <dd class="text-neutral-900 dark:text-white">{{ $authority->phone }}</dd>
                        </div>
                    @endif
                    @if($authority->address_text)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Adresse</dt>
                            <dd class="text-neutral-900 dark:text-white">{{ $authority->address_text }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Office Hours -->
            @if($authority->office_hours)
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Öffnungszeiten</h2>
                    <p class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $authority->office_hours }}</p>
                </div>
            @endif

            <!-- Website -->
            @if($authority->website_url)
                <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                    <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Website</h2>
                    <a href="{{ $authority->website_url }}" target="_blank"
                        class="text-blue-600 dark:text-blue-400 hover:underline break-all">
                        {{ $authority->website_url }}
                    </a>
                </div>
            @endif

            <!-- Metadata -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Informationen</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Erstellt am</dt>
                        <dd class="text-neutral-900 dark:text-white">{{ $authority->created_at->format('d.m.Y H:i') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Zuletzt aktualisiert</dt>
                        <dd class="text-neutral-900 dark:text-white">{{ $authority->updated_at->format('d.m.Y H:i') }}
                        </dd>
                    </div>
                    @if($authority->last_verified_at)
                        <div>
                            <dt class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Zuletzt verifiziert</dt>
                            <dd class="text-neutral-900 dark:text-white">
                                {{ $authority->last_verified_at->format('d.m.Y H:i') }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Notes -->
        @if($authority->notes)
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Notizen</h2>
                <p class="text-neutral-900 dark:text-white whitespace-pre-wrap">{{ $authority->notes }}</p>
            </div>
        @endif

        <!-- Danger Zone -->
        <div class="rounded-xl border border-red-200 bg-red-50 p-6 dark:border-red-900 dark:bg-red-950">
            <h2 class="text-lg font-bold text-red-900 dark:text-red-200 mb-4">Gefahr-Zone</h2>
            <form method="POST" action="{{ route('authorities.destroy', $authority->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                    onclick="return confirm('Sind Sie sicher, dass Sie diese Behörde löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.')"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    Behörde löschen
                </button>
            </form>
        </div>
    </div>
</x-layouts::app>