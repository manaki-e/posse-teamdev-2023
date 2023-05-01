<div class="container mx-auto">
    <div class="divide-y divide-gray-100 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <details class="group" open>
            <summary class="flex cursor-pointer list-none items-center justify-between p-4 text-lg font-medium text-secondary-900 group-open:bg-gray-50">
                絞り込み
                <div class="text-secondary-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="block h-5 w-5 transition-all duration-300 group-open:rotate-180">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
                </div>
            </summary>
            <div class="border-t border-t-gray-100 px-4 text-secondary-500">
                {{ $slot }}
            </div>
        </details>
    </div>
</div>
