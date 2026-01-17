<x-layouts::app :title="__('Fälle')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Fälle</h1>
                    <p class="text-neutral-600 dark:text-neutral-400">Verwaltung aller dokumentierten Rechtsfälle</p>
                </div>
                <a href="#"
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 font-medium transition-colors">
                    + Neuer Fall
                </a>
            </div>
        </div>

        <!-- Table -->
        <div
            class="rounded-xl border border-neutral-200 bg-white overflow-hidden dark:border-neutral-700 dark:bg-neutral-900">
            @php
                $cases = $wg?->cases()->get() ?? collect([]);
            @endphp
            @if($cases->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800">
                            <th class="px-6 py-4 text-left text-sm font-semibold">Titel</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Priorität</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Erstellt</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold">Aktionen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cases as $case)
                                        <tr
                                            class="border-b border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                                            <td class="px-6 py-4 font-medium">{{ $case->case_title }}</td>
                                            <td class="px-6 py-4 text-sm">{{ $case->status ?? 'Offen' }}</td>
                                            <td class="px-6 py-4 text-sm">
                                                @php
                                                    $priorityColor = match ($case->priority ?? 'normal') {
                                                        'high' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-100',
                                                        'medium' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-100',
                                                        default => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-100',
                                                    };
                                                @endphp
                            <span
                                                    class="inline-flex rounded-full px-3 py-1 text-sm {{ $priorityColor }}">{{ ucfirst($case->priority ?? 'Normal') }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-400">
                                                {{ $case->created_at->format('d.m.Y') }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="#"
                                                        class="px-3 py-2 text-sm bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 dark:text-blue-100 rounded transition-colors">Details</a>
                                                    <a href="#"
                                                        class="px-3 py-2 text-sm bg-amber-100 hover:bg-amber-200 text-amber-700 dark:bg-amber-900/30 dark:hover:bg-amber-900/50 dark:text-amber-100 rounded transition-colors">Bearbeiten</a>
                                                    <button
                                                        class="px-3 py-2 text-sm bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/30 dark:hover:bg-red-900/50 dark:text-red-100 rounded transition-colors">Löschen</button>
                                                </div>
                                            </td>
                                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center text-neutral-600 dark:text-neutral-400">
                    <p class="text-lg font-medium">Keine Fälle vorhanden</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>