<?php

$tags = ['勉強会', 'スポーツ', '娯楽'];
$events = ['React勉強会', '野球', 'サッカー', 'pythonで機械学習', 'Go勉強会', 'バスケ'];

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
                <x-slot name="category_tags">
                    @foreach ($tags as $index => $tag)
                    <div class="w-auto mx-1 border rounded border-gray-200 dark:border-gray-600">
                        <div class="flex items-center px-3">
                            <input id="tag_{{ $index }}" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="tag_{{ $index }}" class="w-full py-3 pl-1 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $tag }}</label>
                        </div>
                    </div>
                    @endforeach
                </x-slot>
            </x-user-search-tags>
        </x-user-search-box>
        <div class="container mx-auto my-4">
            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">投稿日</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">投稿者</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">タイトル</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">タグ</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">いいね</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @foreach ($events as $event)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">2023年2月20日</td>
                        <td class="px-6 py-4">遠藤　愛期</td>
                        <td class="px-6 py-4">{{ $event }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600">
                                勉強会
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600">
                                React
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600">
                                プログラミング
                            </span>
                        </td>
                        <td class="px-6 py-4 flex">
                            <button class="mt-1 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                            </button>
                            <p class="pt-1 pl-1 text-lg">7</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 flex justify-end">
                <nav aria-label="Pagination">
                    <ul class="inline-flex items-center -space-x-px rounded-md text-sm shadow-sm">
                        <li>
                            <a href="#" class="inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" aria-current="page" class="z-10 inline-flex items-center border border-gray-300 bg-gray-100 px-4 py-2 font-medium text-gray-700">1 </a>
                        </li>
                        <li>
                            <a href="#" class="inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-gray-500 hover:bg-gray-50">2 </a>
                        </li>
                        <li>
                            <span class="inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-gray-700">... </span>
                        </li>
                        <li>
                            <a href="#" class="inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-gray-500 hover:bg-gray-50">9 </a>
                        </li>
                        <li>
                            <a href="#" class="inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-gray-500 hover:bg-gray-50">10 </a>
                        </li>
                        <li>
                            <a href="#" class="inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
    </x-slot>
</x-user-app>
