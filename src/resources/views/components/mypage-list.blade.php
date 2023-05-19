<a {{ $attributes->merge(['class' => 'cursor-pointer flex justify-between items-center border-t border-gray-300 py-3 px-6 text-sm hover:bg-gray-100 hover:text-gray-700 transition-all ease-in']) }}>
    <div class="flex gap-2">
        <div>
            <img class="w-28 h-24 object-contain" src="{{ asset('images/'.$image_url) }}" alt="Product Image">
        </div>
        <div class="flex flex-col gap-2">
            <p>{{ $title }}</p>
            <span class="text-xs font-bold">{{ $point }}</span>
            <div class="flex gap-1">
                <svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
                <span class="text-xs flex-center">{{ $likes }}</span>
            </div>
            <ul class="flex flex-wrap gap-2">{{ $tag }}</ul>
        </div>
    </div>
    <div class="w-8 h-8">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
            <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
    </div>
</a>
