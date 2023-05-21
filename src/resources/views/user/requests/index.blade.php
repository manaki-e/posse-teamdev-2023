<?php

$tags = ['勉強会', 'スポーツ', '娯楽'];
$events = ['React勉強会', '野球', 'サッカー', 'pythonで機械学習', 'Go勉強会', 'バスケ'];

$request_type = 0;  // 0 : product share, 1: event
$app = [
    ['color' => 'text-blue-400', 'name' => 'Peer Product Share'],
    ['color' => 'text-pink-600', 'name' => 'Peer Event']
]
?>


<x-user-app>
    <x-slot name="header_slot">
        <x-user-header textColor="text-green-400" bgColor="bg-green-400">
            <x-slot:app_name>Peer Request</x-slot:app_name>
            <x-slot:button_text>リクエスト登録</x-slot:button_text>
            <x-slot:earned_point>580</x-slot:earned_point>
            <x-slot:distribution_point>5000</x-slot:distribution_point>
        </x-user-header>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-side-navi>
            <div class="mx-auto max-w-5xl">
                <x-user-search-box bgColor="bg-green-400">
                    <x-user-search-tags>
                        <x-slot name="category1">区分</x-slot>
                        <x-slot name="available">アイテム</x-slot>
                        <x-slot name="unavailable">イベント</x-slot>
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
                <div class="mx-auto max-w-5xl my-4">
                    <div class="mx-auto grid grid-cols-2 gap-4">
                        @for ($i = 0; $i < 5; $i++) <div class="col-span-1">
                            <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
                                <div class="rounded-lg text-xs shadow-md p-4 pb-1 text-gray-500 bg-white">
                                    <!-- イベント名 -->
                                    <div class="w-full text-xl text-gray-800 mb-4">
                                        <p class="font-bold pl-2 border-l-4 border-green-400">トラックボール貸してほしいです</p>
                                    </div>
                                    <!-- 概要 -->
                                    <div class="w-full mb-2 text-sm text-gray-800">
                                        <p class="text-gray-500">
                                            私は場合けっしてその安心院に従ってののためで被せるたない。
                                            やはり今が逡巡学はとうとうその学習だろざるかもを信ずるば行くだのも講演きまっででて、なぜにはできでなないん。
                                        </p>
                                    </div>
                                    <div class="flex justify-between">
                                        <div class="flex flex-wrap gap-1 items-center">
                                            <span class="items-center gap-1 rounded-full border border-gray-300 bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-400">
                                                PC
                                            </span>
                                            <span class="items-center gap-1 rounded-full border border-gray-300 bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-400">
                                                Macbook
                                            </span>
                                        </div>
                                        <a href="#" class="divide-y divide-gray-200 flex justify-end">
                                            <div class="flex justify-end space-x-4 p-1 rounded-md hover:bg-gray-50">
                                                <div class="pl-1">
                                                    <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1552058544-f2b08422138a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNTgwfDB8MXxzZWFyY2h8NXx8cGVyc29ufGVufDB8fHx8MTY4MzAzMzA2OA&ixlib=rb-4.0.3&q=80&w=400" alt="Neil image">
                                                </div>
                                                <div class="min-w-0 flex items-center">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        五十嵐 佳貴
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <!-- ボタン・モーダル -->
                                    <div x-data="{ modelOpen: false }">
                                        <div @click="modelOpen =!modelOpen" class="flex items-center justify-center px-3">
                                            <x-user-register-button textColor="text-green-400" bgColor="bg-white" borderColor="border-green-400">
                                                <x-slot name="button">リクエストに応える</x-slot>
                                            </x-user-register-button>
                                        </div>

                                        <div x-cloak x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                                <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                                <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-40 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                                    <div class="flex items-center justify-between space-x-4">
                                                        <h1 class="text-xl font-semibold text-gray-800 pl-2 border-l-4 border-green-400">リクエストに応える</h1>
                                                        <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="mt-5">
                                                        <p class="block text-sm mb-4 text-gray-700">次のアプリに移動します</p>
                                                        <div class="flex justify-center items-center">
                                                            <div class="flex items-center {{ $app[$request_type]['color'] }}">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="stroke-current">
                                                                    <path d="M3 12C3 13.1819 3.23279 14.3522 3.68508 15.4442C4.13738 16.5361 4.80031 17.5282 5.63604 18.364C6.47177 19.1997 7.46392 19.8626 8.55585 20.3149C9.64778 20.7672 10.8181 21 12 21C13.1819 21 14.3522 20.7672 15.4442 20.3149C16.5361 19.8626 17.5282 19.1997 18.364 18.364C19.1997 17.5282 19.8626 16.5361 20.3149 15.4442C20.7672 14.3522 21 13.1819 21 12C21 10.8181 20.7672 9.64778 20.3149 8.55585C19.8626 7.46392 19.1997 6.47177 18.364 5.63604C17.5282 4.80031 16.5361 4.13738 15.4442 3.68508C14.3522 3.23279 13.1819 3 12 3C10.8181 3 9.64778 3.23279 8.55585 3.68508C7.46392 4.13738 6.47177 4.80031 5.63604 5.63604C4.80031 6.47177 4.13738 7.46392 3.68508 8.55585C3.23279 9.64778 3 10.8181 3 12Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M10 16V8H12.5C13.163 8 13.7989 8.26339 14.2678 8.73223C14.7366 9.20107 15 9.83696 15 10.5C15 11.163 14.7366 11.7989 14.2678 12.2678C13.7989 12.7366 13.163 13 12.5 13H10" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                                <span class="ml-3 font-medium text-xl font-patua">
                                                                    {{ $app[$request_type]['name'] }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mt-6">
                                                            <a href="#">
                                                                <x-user-register-button textColor="text-white" bgColor="bg-green-400" borderColor="border-green-400">
                                                                    <x-slot name="button">次へ</x-slot>
                                                                </x-user-register-button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 日付・いいね -->
                                    <div class="flex items-end justify-between mb-1">
                                        <p>2023.04.23</p>
                                        <div class="likes">
                                            <div class="flex relative">
                                                <button class="text-gray-500">
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
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </x-user-side-navi>
    </x-slot>
</x-user-app>
<style>
    [x-cloak] {
        display: none;
    }
</style>
