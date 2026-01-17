<x-layouts::app :title="__('Pflege-WGs')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Pflege-WGs</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">Verwaltung aller eingetragenen Wohngemeinschaften</p>
                </div>
                <a href="{{ route('wgs.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 font-medium transition-colors">
                    + Neue WG
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden dark:border-neutral-700 dark:bg-neutral-900">
            @if($wgs->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800">
                            <th class="px-6 py-4 text-left text-sm font-semibold">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Adresse</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold">Aktionen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wgs as $w)
                            <tr class="border-b border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                                <td class="px-6 py-4 font-medium">{{ $w->wg_name }}</td>
                                <td class="px-6 py-4 text-neutral-600 dark:text-neutral-400">{{ $w->address_text ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($w->wg_id === $wg?->wg_id)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-100">✓ Aktiv</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-neutral-100 px-3 py-1 text-sm text-neutral-700 dark:bg-neutral-800 dark:text-neutral-400">Inaktiv</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('wgs.show', $w->wg_id) }}" class="px-3 py-2 text-sm bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 dark:text-blue-100 rounded transition-colors">Details</a>
                                        <a href="{{ route('wgs.edit', $w->wg_id) }}" class="px-3 py-2 text-sm bg-amber-100 hover:bg-amber-200 text-amber-700 dark:bg-amber-900/30 dark:hover:bg-amber-900/50 dark:text-amber-100 rounded transition-colors">Bearbeiten</a>
                                        <form method="POST" action="{{ route('wgs.destroy', $w->wg_id) }}" onsubmit="return confirm('WG wirklich löschen?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 text-sm bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/30 dark:hover:bg-red-900/50 dark:text-red-100 rounded transition-colors">Löschen</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center text-neutral-600 dark:text-neutral-400">
                    <p class="text-lg font-medium">Keine WGs vorhanden</p>
                    <p class="text-sm mt-2"><a href="{{ route('wgs.create') }}" class="text-blue-600 hover:underline">Neue WG erstellen</a></p>
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
