<div {{ $attributes->merge(['class' => 'relative flex gap-4 justify-between items-center border-t border-gray-300 py-3 px-6 text-sm']) }}>
    <div class="flex gap-2 font-mono">
        <div>
            <img class="w-20 h-20 object-contain" src="{{ asset('images/'.$image_url) }}" alt="Product Image">
        </div>
        <div class="flex flex-col gap-2">
            <p>{{ $title }}</p>
            <span class="text-xs font-bold">{{ $point }}</span>
            <ul class="flex flex-wrap gap-2">{{ $tag }}</ul>
        </div>
    </div>
    <div class="flex-center gap-4">
        {{ $button }}
    </div>
    {{ $slot ?? '' }}
</div>
