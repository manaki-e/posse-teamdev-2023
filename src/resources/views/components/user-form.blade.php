@props([
'method' => 'POST'
])
@php
$method = strtoupper($method);
@endphp
<div class="mx-auto max-w-5xl relative flex flex-col rounded-xl bg-white text-gray-700 shadow-none">
    <div class="absolute top-5 left-5">
        <button class="rounded-md text-gray-600 px-4 py-2" onClick="history.back();">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-6 h-6">
                <path strokeLinecap="round" stroke-width="2" strokeLinejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </button>
    </div>
    <div class="w-full mx-auto px-16 py-8">
        <form {{ $attributes->merge(['method' => $method === 'GET' ? 'GET' : 'POST']) }} class="text-center mt-8">
            @if ($method !== 'GET')
            @csrf
            @endif

            @if ($method !== 'GET' && $method !== 'POST')
            @method($method)
            @endif

            <h2 class="mx-auto font-sans text-2xl font-bold text-gray-600">
                {{ $title }}
            </h2>
            {{ $slot }}
        </form>
    </div>
</div>
