<div {{ $attributes->merge(['class' => 'flex justify-between items-center border-t border-gray-300 py-3 pl-6 pr-12 text-sm']) }}>
    <div class="flex gap-4 font-mono">
        @if ($app == 'PI')
        <div class="flex-center w-10 h-10 border-2 border-blue-400 rounded-lg">
            <x-icon-pps></x-icon-pps>
        </div>
        @elseif ($app == 'PE')
        <div class="flex-center w-10 h-10 border-2 border-pink-600 rounded-lg">
            <x-icon-pe></x-icon-pe>
        </div>
        @elseif ($app == 'PP')
        <div class="flex-center w-10 h-10 border-2 border-peer-perk rounded-lg">
            <x-application-logo></x-application-logo>
        </div>
        @endif
        <div class="flex flex-col gap-2">
            <p class="text-gray-800 text-base">{{ $name ?? '' }}</p>
            <p class="text-gray-500 text-xs">{{ $created_at ?? '' }}</p>
        </div>
    </div>
    <div class="flex-center gap-2">
        <p class="text-gray-800 text-base">{{ $point ?? '' }}</p>
    </div>
    {{ $slot ?? '' }}
</div>
