<?php

$tags = ['PC', 'マウス', 'ディスプレイ', 'スマホ', 'ヘッドホン', 'タブレット']

?>

<x-user-app>
    <x-slot name="header_slot">
        <x-header-top>
            5000
        </x-header-top>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-form method="POST">
            <x-slot name="title">アイテムの出品</x-slot>
            <x-slot name="button">出品する</x-slot>
            <section class="text-left w-2xl">

                <div class="mx-auto mt-4 max-w-lg">
                    <label for="example5" class="mb-1 block text-sm font-medium text-gray-700">出品画像</label>
                    <label class="flex w-full cursor-pointer appearance-none items-center justify-center rounded-md border-2 border-dashed border-gray-200 p-6 transition-all hover:border-primary-300">
                        <div class="space-y-1 text-center">
                            <div class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                </svg>
                            </div>
                            <div class="text-gray-600"><a href="#" class="font-medium text-primary-500 hover:text-primary-700">クリックして追加</a> または ファイルをドロップ</div>
                            <p class="text-sm text-gray-500">SVG, PNG, JPG or GIF (max. 800x400px)</p>
                        </div>
                        <input id="example5" type="file" class="sr-only" required/>
                    </label>
                </div>
                <section class="my-6">
                    <h3 class="mb-2 text-xl text-gray-600 font-extrabold border-b border-gray-500">アイテムの詳細</h3>
                    <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">カテゴリー</h4>
                    <div class="flex overflow-x-scroll w-full max-w-lg text-sm font-medium text-gray-900 bg-white">
                        <div class="flex">
                            @foreach ($tags as $index => $tag)
                            <div class="min-w-max mx-1 border rounded border-gray-200">
                                <div class="flex items-center px-3">
                                    <input id="tag_{{ $index }}" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                    <label for="tag_{{ $index }}" class="w-auto py-3 pl-1 text-sm font-medium text-gray-900">{{ $tag }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">アイテムの状態</h4>
                    <div class="mb-4">
                        <select id="example1" class="p-1 block w-full rounded-md border-gray-300 shadow-sm text-lg text-gray-500" required>
                            <option value="">選択してください</option>
                            <option value="">新品・未使用</option>
                            <option value="">未使用に近い</option>
                            <option value="">目立った傷や汚れなし</option>
                            <option value="">やや傷や汚れあり</option>
                            <option value="">傷や汚れあり</option>
                            <option value="">全体的に状態が悪い</option>
                        </select>
                    </div>
                </section>
                <section class="my-6">
                    <h3 class="mb-2 text-xl text-gray-600 font-extrabold border-b border-gray-500">アイテム名と説明</h3>
                    <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">アイテム名</h4>
                    <div class="mx-auto">
                        <input type="text" class="p-1 block w-full rounded-md border-gray-300 shadow-sm" required/>
                    </div>
                    <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">アイテムの説明</h4>
                    <div class="mx-auto">
                        <textarea class="p-1 block w-full rounded-md border-gray-300 shadow-sm" rows="3" required></textarea>
                    </div>
                </section>



            </section>
        </x-user-form>
    </x-slot>
</x-user-app>
