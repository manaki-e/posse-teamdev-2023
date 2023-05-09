<?php

$tags = ['勉強会', 'スポーツ', '娯楽', 'プログラミング', 'React', 'Vue', 'Laravel']

?>

<x-user-app>
    <x-slot name="header_slot">
        <x-header-top>
            5000
        </x-header-top>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-form method="POST">
            <x-slot name="title">イベントの開催</x-slot>
            <x-slot name="button">登録する</x-slot>
            <section class="text-left w-2xl">
                <section class="my-6">
                    <h3 class="mb-2 text-xl text-gray-600 font-extrabold border-b border-gray-500">アイテムの詳細</h3>
                    <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">カテゴリー</h4>
                    <div class="w-full flex flex-wrap max-w-lg text-sm font-medium text-gray-900 bg-white">
                        @foreach ($tags as $index => $tag)
                        <div class="min-w-max m-1 border rounded border-gray-200">
                            <div class="flex items-center px-3">
                                <input id="tag_{{ $index }}" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                <label for="tag_{{ $index }}" class="w-auto py-3 pl-1 text-sm font-medium text-gray-900">{{ $tag }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">開催形態</h4>
                    <div class="mx-auto">
                        <select id="example1" class="p-1 block w-full rounded-md border-gray-300 shadow-sm text-lg text-gray-500" required>
                            <option value="">選択してください</option>
                            <option value="">対面</option>
                            <option value="">オンライン</option>
                            <option value="">対面・オンライン併用</option>
                            <option value="">未定</option>
                        </select>
                    </div>
                </section>
                <section class="my-6">
                    <h3 class="mb-2 text-xl text-gray-600 font-extrabold border-b border-gray-500">イベント名と概要</h3>
                    <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">イベント名</h4>
                    <div class="mx-auto">
                        <input type="text" class="p-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                    </div>
                    <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">イベントの概要</h4>
                    <div class="mx-auto">
                        <textarea class="p-1 block w-full rounded-md border-gray-300 shadow-sm" rows="3" required></textarea>
                    </div>
                    <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">開催予定日<span class="text-xs text-gray-400">（任意）</span></h4>
                    <div date-rangepicker class="flex items-center justify-center">
                        <div class="relative">
                            <input name="start" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-2.5" placeholder="開始日">
                        </div>
                        <span class="mx-4 text-gray-500">〜</span>
                        <div class="relative">
                            <input name="end" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-2.5" placeholder="終了日">
                        </div>
                    </div>

                </section>
            </section>
        </x-user-form>
    </x-slot>
</x-user-app>
