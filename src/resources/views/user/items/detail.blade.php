<?php

$imgs = [
    'https://images.unsplash.com/photo-1553525245-9d0d32b61e75?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNTgwfDB8MXxzZWFyY2h8OHx8bWFjYm9va2FpcnxlbnwwfHx8fDE2ODMxMTk1MzU&ixlib=rb-4.0.3&q=80&w=400',
    'https://images.unsplash.com/photo-1616502844612-4b3d523fc00e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNTgwfDB8MXxzZWFyY2h8MTB8fG1hY2Jvb2thaXJ8ZW58MHx8fHwxNjgzMTE5NTM1&ixlib=rb-4.0.3&q=80&w=400',
    'https://images.unsplash.com/photo-1532198528077-0d9e4ca9bb40?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNTgwfDB8MXxzZWFyY2h8OXx8bWFjYm9va2FpcnxlbnwwfHx8fDE2ODMxMTk1MzU&ixlib=rb-4.0.3&q=80&w=400'
]

?>

<x-user-app>
    <x-slot name="header_slot">
        <x-user-header textColor="text-blue-400" bgColor="bg-blue-400">
            <x-slot:app_name>Peer Product Share</x-slot:app_name>
            <x-slot:button_text>アイテム登録</x-slot:button_text>
        </x-user-header>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-side-navi>
            <div>
                <div class="pb-8">
                    <nav class="flex mx-auto max-w-screen-xl px-4 md:px-8" aria-label="Breadcrumb">
                        <ol class="my-4 inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="#" class="inline-flex items-center text-lg text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                    一覧
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-lg text-gray-500 md:ml-2 dark:text-gray-400">MacBook
                                        Air</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <div class="mx-auto max-w-screen-5xl px-4 md:px-8">
                        <div class="">
                            <div class="grid gap-8 grid-cols-2">
                                <!-- images - start -->
                                <div class="md:py-8">
                                    <div class="flex gap-2" x-data="{ activeImage: 0 }">
                                        <div class="w-1/4">
                                            <ul class="flex flex-col gap-1">
                                                <li class="aspect-square shadow-md">
                                                    <img src="{{ $imgs[0] }}" alt="アイテム写真">
                                                </li>
                                                <li class="aspect-square shadow-md">
                                                    <img src="{{ $imgs[1] }}" alt="アイテム写真">
                                                </li>
                                                <li class="aspect-square shadow-md">
                                                    <img src="{{ $imgs[2] }}" alt="アイテム写真">
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="w-3/4 mb-4">
                                            <ul class="flex gap-2 h-full my-auto">
                                                <li class="my-auto w-8 flex-center">
                                                    <div @click="activeImage = activeImage + 2" class="rounded-full overflow-hidden bg-gray-200 p-1 cursor-pointer flex jusitify-center items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                                        </svg>
                                                    </div>
                                                </li>
                                                <li class="flex justify-items-center items-center">
                                                    <div :class="{ 'block': activeImage % 3 === 0, 'hidden': activeImage % 3 !== 0}" x-show.transition.in.opacity.duration.600="activeImage % 3 === 0">
                                                        <img class="shadow-md" src="{{ $imgs[0] }}" alt="アイテム写真">
                                                    </div>
                                                    <div :class="{ 'block': activeImage % 3 === 1, 'hidden': activeImage % 3 !== 1}" x-show.transition.in.opacity.duration.600="activeImage % 3 === 1">
                                                        <img class="shadow-md" src="{{ $imgs[1] }}" alt="アイテム写真">
                                                    </div>
                                                    <div :class="{ 'block': activeImage % 3 === 2, 'hidden': activeImage % 3 !== 2}" x-show.transition.in.opacity.duration.600="activeImage % 3 === 2">
                                                        <img class="shadow-md" src="{{ $imgs[2] }}" alt="アイテム写真">
                                                    </div>
                                                </li>
                                                <li class="my-auto w-8 flex-center">
                                                    <div @click="activeImage = activeImage + 1" class="rounded-full overflow-hidden bg-gray-200 p-1 cursor-pointer flex jusitify-center items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                        </svg>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- images - end -->

                                <!-- content - start -->
                                <div class="md:py-8">
                                    <h1 class="text-3xl font-bold mb-1 pl-2 border-l-4 border-blue-400">MacBook Air</h1>
                                    <div class="px-2 flex mt-4 justify-between">
                                        <p class="title-font font-medium text-2xl text-gray-500">600 pt</p>
                                        <span class="flex items-center">
                                            <button type="">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                </svg>
                                            </button>
                                            <span class="text-gray-600 ml-3">4 likes</span>
                                        </span>
                                    </div>
                                    <x-user-register-button textColor="text-blue-400" borderColor=" border-blue-400">
                                        <x-slot name="button">借りる</x-slot>
                                    </x-user-register-button>

                                    <h3 class="text-xl mb-1 pb-1 dark:text-white border-b">アイテムの説明
                                    </h3>
                                    <p class="mb-4 text-base text-gray-500">
                                        3年前に買ったmacbookairですが、ほとんど使用せず眠っていました。<br>
                                        Intel Core i5 1.6GHz<br>
                                        8GB<br>
                                    </p>
                                    <h3 class="text-xl mb-1 pb-1 dark:text-white border-b">アイテムの状態
                                    </h3>
                                    <p class="mb-4 text-base text-gray-500">傷なし</p>
                                    <h3 class="text-xl mb-1 pb-1 dark:text-white border-b">カテゴリ</h3>
                                    <div class="mb-4">
                                        <span class="inline-flex items-center gap-1 rounded-full border border-gray-300 bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-400">
                                            PC
                                        </span>
                                        <span class="inline-flex items-center gap-1 rounded-full border border-gray-300 bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-400">
                                            デバイス
                                        </span>
                                        <span class="inline-flex items-center gap-1 rounded-full border border-gray-300 bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-400">
                                            利用不可
                                        </span>
                                    </div>
                                    <h3 class="text-xl mb-1 pb-1 dark:text-white border-b">出品者</h3>

                                    <a href="#" class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <div class="sm:pb-4">
                                            <div class="flex items-center space-x-4 rounded hover:bg-gray-200">
                                                <div class="flex-shrink-0 pl-1">
                                                    <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1552058544-f2b08422138a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNTgwfDB8MXxzZWFyY2h8NXx8cGVyc29ufGVufDB8fHx8MTY4MzAzMzA2OA&ixlib=rb-4.0.3&q=80&w=400" alt="Neil image">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                        五十嵐　佳貴
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        email@flowbite.com
                                                    </p>
                                                </div>
                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!-- content - end -->
                            </div>
                        </div>
                    </div>
                </div>
        </x-user-side-navi>
    </x-slot>
</x-user-app>
