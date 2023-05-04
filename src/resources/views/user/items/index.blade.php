<?php

$tags = ['PC', 'マウス', 'ディスプレイ', 'スマホ', 'ヘッドホン']

?>


<x-user-app>
    <x-slot name="header_slot">
        <x-header-top>
            5000
        </x-header-top>
        <x-header-bottom>
        </x-header-bottom>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-search-box>
            <x-user-search-tags>
                <x-slot name="category1">利用状況</x-slot>
                <x-slot name="available">利用可能</x-slot>
                <x-slot name="unavailable">利用不可</x-slot>
                <x-slot name="category_tags">
                    @foreach ($tags as $index => $tag)
                    <div class="w-auto mx-1 border rounded border-gray-200">
                        <div class="flex items-center px-3">
                            <input id="tag_{{ $index }}" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                            <label for="tag_{{ $index }}" class="w-full py-3 pl-1 text-sm font-medium text-gray-900">{{ $tag }}</label>
                        </div>
                    </div>
                    @endforeach
                </x-slot>
            </x-user-search-tags>
        </x-user-search-box>

        <section class="text-gray-600 body-font">
            <div class="container px-5 py-12 mx-auto">
                <div class="flex flex-wrap -m-4">
                    @for ($i = 0; $i < 10; $i++) <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                        <a href="#">
                            <div class="m-2 bg-white">
                                <div class="block relative h-48 rounded overflow-hidden">
                                    <img alt="ecommerce" class="object-cover object-center w-full h-full block" src="https://pixabay.com/get/g99d6b4842ba7137ee41f04054bba656fac302e366af1162bca527744c5492ffb9087ad3414f357dcdf8c1bc8c5f9d28d3629d201f399006e087b705c2d7f62a9_640.jpg">
                                </div>
                                <div class="p-4">
                                    <h2 class="text-gray-900 title-font text-lg font-medium">MacBook Air</h2>
                                    <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">Apple Watch Series 7 GPS, Aluminium Case, Starlight Sport</h3>
                                    <div class="flex justify-between">
                                        <p class="mt-1">600 pt</p>
                                        <div class="flex relative">
                                            <button class="mt-1 text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                </svg>
                                            </button>
                                            <div class="mt-3">
                                                <p class="text-xs">11</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                </div>
                @endfor
            </div>
            </div>
        </section>
    </x-slot>
</x-user-app>
