<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <h2 class="text-2xl font-bold mb-4">Willkommen, {{ Auth::user()->name }}!</h2>
            <p class="text-neutral-600 dark:text-neutral-400 mb-2">
                WG-ID: <span class="font-mono font-semibold">{{ $wg->id }}</span>
            </p>
            <p class="text-neutral-600 dark:text-neutral-400">
                WG-Name: <span class="font-semibold">{{ $wg->name }}</span>
            </p>
        </div>

        <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <iframe 
                src="{{ $formUrl }}" 
                class="w-full h-full min-h-[800px]"
                frameborder="0"
                title="WG Formular"
                allowfullscreen
            ></iframe>
        </div>
    </div>
</x-layouts::app>
