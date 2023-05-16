<!--
    引数は色
    bgColorには以下の色を指定する
        Product Share : text-blue-400 / bg-blue-400
        Event : text-pink-600 / bg-pink-600
        Request : text-peer-request / bg-peer-request
-->
<div class="">
    <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
        <details class="group rounded-lg" open>
            <summary
                {{ $attributes->merge(['class' => 'flex h-10 rounded text-xs cursor-pointer group list-none items-center justify-between shadow-md p-4 text-white font-bold '.$bgColor]) }}>
                絞り込み
                <div class="text-secondary-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="block h-5 w-5 transition-all duration-300 group-open:rotate-180">
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
