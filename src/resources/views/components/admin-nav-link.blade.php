@props(['active'])

@php
$classes = ($active ?? false)
? 'flex items-center admin-text-green admin-bg-basic hover:bg-gray-200 py-4 pl-6 nav-item'
: 'flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <div class="w-8 h-8 mr-6">
        {{ $icon }}
    </div>
    {{ $slot }}
</a>
