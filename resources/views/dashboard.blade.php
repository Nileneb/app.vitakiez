<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header with API Token Button -->
        <div
            class="flex items-center justify-between rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <div>
                <h2 class="text-2xl font-bold mb-2">Willkommen, {{ Auth::user()->name }}!</h2>
                @if($wg)
                    <p class="text-neutral-600 dark:text-neutral-400 mb-2">
                        WG-ID: <span class="font-mono font-semibold">{{ $wg->wg_id }}</span>
                    </p>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        WG-Name: <span class="font-semibold">{{ $wg->wg_name }}</span>
                    </p>
                @else
                    <div
                        class="inline-flex items-center gap-2 rounded-lg bg-amber-100 px-3 py-2 text-amber-900 dark:bg-amber-900/30 dark:text-amber-100">
                        <span class="font-semibold">Keine WG erfasst</span>
                        <span class="text-sm">Bitte erst das Formular ausfüllen – danach wird die WG hier
                            gespeichert.</span>
                    </div>
                @endif
            </div>









</x-layouts::app>