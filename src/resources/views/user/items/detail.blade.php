<?php

$imgs = [
    'https://images.unsplash.com/photo-1553525245-9d0d32b61e75?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNTgwfDB8MXxzZWFyY2h8OHx8bWFjYm9va2FpcnxlbnwwfHx8fDE2ODMxMTk1MzU&ixlib=rb-4.0.3&q=80&w=400',
    'https://images.unsplash.com/photo-1616502844612-4b3d523fc00e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNTgwfDB8MXxzZWFyY2h8MTB8fG1hY2Jvb2thaXJ8ZW58MHx8fHwxNjgzMTE5NTM1&ixlib=rb-4.0.3&q=80&w=400',
    'https://images.unsplash.com/photo-1532198528077-0d9e4ca9bb40?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNTgwfDB8MXxzZWFyY2h8OXx8bWFjYm9va2FpcnxlbnwwfHx8fDE2ODMxMTk1MzU&ixlib=rb-4.0.3&q=80&w=400'
]

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
        <div class="bg-white pb-8">
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
                            <span class="ml-1 text-lg text-gray-500 md:ml-2 dark:text-gray-400">MacBook Air</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="mx-auto max-w-screen-xl px-4 md:px-8">
                <div class="grid gap-8 md:grid-cols-2">
                    <!-- images - start -->
                    <div x-data="{ activeTab:  0 }">
                        <div class="grid gap-4 lg:grid-cols-5">
                            <ul class="order-last flex gap-4 lg:order-none lg:flex-col">
                                @foreach ($imgs as $index => $img)
                                <li>
                                    <a @click="activeTab = {{ $index }}" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3" :class="{ 'relative text-primary-700  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-primary-700': activeTab === {{ $index }} }">
                                        <div class="overflow-hidden rounded-lg bg-gray-100">
                                            <img src="{{ $img }}" loading="lazy" alt="Photo by Himanshu Dewangan" class="h-full w-full object-cover object-center" />
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="h-full relative overflow-hidden rounded-lg lg:col-span-4">
                                @foreach ($imgs as $index => $img)
                                <div :class="{ '!block': activeTab === {{ $index }} }" class="hidden">
                                    <img src="{{ $img }}" loading="lazy" alt="Photo by Himanshu Dewangan" class="w-full object-center overflow-hidden" />
                                    <span class="absolute left-0 top-0 rounded-br-lg bg-red-500 px-3 py-1.5 text-sm uppercase tracking-wider text-white">sale</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- images - end -->

                    <!-- content - start -->
                    <div class="md:py-8">
                        <h1 class="text-black text-3xl title-font font-medium mb-1">MacBook Air</h1>
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
                        <x-user-register-button>
                            <x-slot name="button">レンタルする</x-slot>
                        </x-user-register-button>

                        <h3 class="text-xl text-black mb-1 font-extrabold dark:text-white border-b">アイテムの説明</h3>
                        <p class="mb-4 text-lg text-gray-500">
                            3年前に買ったmacbookairですが、ほとんど使用せず眠っていました。<br>
                            Intel Core i5 1.6GHz<br>
                            8GB<br>
                        </p>
                        <h3 class="text-xl text-black mb-1 font-extrabold dark:text-white border-b">アイテムの状態</h3>
                        <p class="mb-4 text-lg text-gray-500">傷なし</p>
                        <h3 class="text-xl text-black mb-1 font-extrabold dark:text-white border-b">タグ</h3>
                        <p class="mb-4 text-lg text-gray-500">PC デバイス 利用不可</p>
                        <h3 class="text-xl text-black mb-1 font-extrabold dark:text-white border-b">出品者</h3>

                        <a href="#" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div class="pb-3 sm:pb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
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
    </x-slot>
</x-user-app>
