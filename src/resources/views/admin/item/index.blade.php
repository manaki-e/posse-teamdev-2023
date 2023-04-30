<x-admin-app>
    <x-slot name="title">
        {{ __('アイテム一覧') }}
    </x-slot>
    <x-slot name="discription">
        {{ __('登録済みアイテムと登録申請待ちアイテムの一覧が表示されます') }}
    </x-slot>

    <div class="bg-white shadow rounded-lg md:p-6 w-full">
        <div x-data="{ activeTab: 0 }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 0}">
                            登録済みアイテム
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                41
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 1}">
                            登録申請待ちアイテム
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                3
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="py-3">
                <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">商品名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">利用ポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">貸出者氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-center">貸出状況</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ([0, 1, 2, 3, 4, 5] as $item)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">昇降式テーブル</th>
                                    <td class="px-6 py-4 text-right">1000 pt</td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="hover:text-blue-700">井戸 宗達</a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                            </svg>
                                            貸出可能
                                        </span>
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#"><x-admin-button-detail></x-admin-button-detail></a>
                                        <a href="#"><x-admin-button-edit>ポイント再設定</x-admin-button-edit></a>
                                        <a href="#"><x-admin-button-delete></x-admin-button-delete></a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">ゲーミングチェア</th>
                                    <td class="px-6 py-4 text-right">550 pt</td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="hover:text-blue-700">武田 龍一</a>
                                    </td>
                                    <td class=" px-6 py-4 text-center">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                            </svg>
                                            貸出中
                                        </span>
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#"><x-admin-button-detail></x-admin-button-detail></a>
                                        <a href="#"><x-admin-button-edit>ポイント再設定</x-admin-button-edit></a>
                                        <a href="#"><x-admin-button-delete></x-admin-button-delete></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-center">
                        <nav aria-label="Pagination">
                            <ul class="inline-flex items-center -space-x-px rounded-md text-sm shadow-sm">
                                <li>
                                    <a href="#" class="inline-flex items-center space-x-2 rounded-l-md border border-gray-300 bg-white px-4 py-2 font-medium text-gray-500 hover:bg-gray-50">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Previous</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" aria-current="page" class="z-10 inline-flex items-center border border-gray-300 bg-gray-100 px-4 py-2 font-medium text-gray-700">1
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-gray-500 hover:bg-gray-50">2
                                    </a>
                                </li>
                                <li>
                                    <span class="inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-gray-700">...
                                    </span>
                                </li>
                                <li>
                                    <a href="#" class="inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-gray-500 hover:bg-gray-50">9
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-gray-500 hover:bg-gray-50">10
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="inline-flex items-center space-x-2 rounded-r-md border border-gray-300 bg-white px-4 py-2 font-medium text-gray-500 hover:bg-gray-50">
                                        <span>Next</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">商品名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">登録申請者氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">申請日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ([0, 1, 2] as $item)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">ディスプレイ</th>
                                    <td class="px-6 py-4">
                                        <a href="#" class="hover:text-blue-700">井戸 宗達</a>
                                    </td>
                                    <td class=" px-6 py-4">2023年4月30日 13:99:00
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#"><x-admin-button-detail></x-admin-button-detail></a>
                                        <a href="#"><x-admin-button-edit>ポイント設定して承認</x-admin-button-edit></a>
                                        <a href="#"><x-admin-button-delete></x-admin-button-delete></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app>
