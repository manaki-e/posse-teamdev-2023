@props(['active'])

@php
$classes = ($active ?? false)
? 'flex justify-between items-center border-t border-gray-300 py-3 px-6 text-sm bg-gray-300'
: 'flex justify-between items-center border-t border-gray-300 py-3 px-6 text-sm hover:bg-gray-100 hover:text-gray-700 transition-all ease-in';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    <div class="w-4 h-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
            <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
    </div>
</a>
