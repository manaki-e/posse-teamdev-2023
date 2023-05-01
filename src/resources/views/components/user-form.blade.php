@props([
    'method' => 'POST'
])
@php
    $method = strtoupper($method);
@endphp
<div class="container mx-auto relative flex flex-col rounded-xl bg-white text-gray-700 shadow-none">
    <div class="absolute top-5 left-5">
        <button class="rounded-md text-gray-600 px-4 py-2" onClick="history.back();">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-6 h-6">
            <path strokeLinecap="round" stroke-width="2" strokeLinejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </button>
    </div>
    <form {{ $attributes->merge(['method' => $method === 'GET' ? 'GET' : 'POST']) }} class="text-center mx-auto mt-8">
        @if ($method !== 'GET')
            @csrf
        @endif

        @if ($method !== 'GET' && $method !== 'POST')
            @method($method)
        @endif

        <h2 class="block font-sans text-4xl font-bold text-gray-600">
            {{ $title }}
        </h2>
        {{ $slot }}
        <x-user-register-button>
            <x-slot name="button">
                {{ $button }}
            </x-slot>
        </x-user-register-button>
    </form>
</div>
