<x-admin-app>
    <x-slot name="title">
        {{ __('ユーザ詳細') }}
    </x-slot>
    <x-slot name="discription">
        {{ __('特定のユーザに関するテータ（個人情報・アイテム取引履歴・登録済みアイテム一覧・参加したイベント一覧・主催したイベント一覧）が表示されます。') }}
    </x-slot>

    <div class="bg-white shadow rounded-lg md:p-6 w-full my-4">
        <nav class="flex mx-auto max-w-screen-xl px-4 md:px-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-lg text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        ユーザ一覧
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-lg text-gray-500 md:ml-2 dark:text-gray-400">ユーザ詳細</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex">
            <div>
                <div class="w-36 h-36 mx-16 my-4">
                    <img class="rounded-full overflow-hidden border-4 admin-border-green" src="{{ asset('images/sample_product_1.jpeg') }}" alt="ユーザ写真">
                </div>
            </div>
            <div>
                <div class="my-4">
                    <p class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">松本 透歩 / Matsumoto Yukiho</p>
                    <div class="h-1 w-40 bg-indigo-500 rounded"></div>
                </div>
                <div>
                    <ul class="flex flex-col gap-2 p-0">
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">Name:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">Matsumoto Yukiho</p>
                        </li>
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">Email:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">posse@posse-ap.com</p>
                        </li>
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">所属部署:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">営業</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="">
            <div class="flex flex-wrap -m-4 text-center">
                <div class="p-4 w-1/4">
                    <x-admin-point>
                        <x-slot name="point">
                            {{ __('2960') }}
                        </x-slot>
                        <x-slot name="discription">
                            {{ __('累計獲得ポイント') }}
                        </x-slot>
                    </x-admin-point>
                </div>
                <div class="p-4 w-1/4">
                    <x-admin-point>
                        <x-slot name="point">
                            {{ __('20700') }}
                        </x-slot>
                        <x-slot name="discription">
                            {{ __('累計消費ポイント') }}
                        </x-slot>
                    </x-admin-point>
                </div>
                <div class="p-4 w-1/4">
                    <x-admin-point>
                        <x-slot name="point">
                            {{ __('500') }}
                        </x-slot>
                        <x-slot name="discription">
                            {{ __('今月獲得ポイント') }}
                        </x-slot>
                    </x-admin-point>
                </div>
                <div class="p-4 w-1/4">
                    <x-admin-point>
                        <x-slot name="point">
                            {{ __('1500') }}
                        </x-slot>
                        <x-slot name="discription">
                            {{ __('今月消費ポイント') }}
                        </x-slot>
                    </x-admin-point>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg md:p-6 w-full my-4">
        <div x-data="{ activeTab: 0 }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 0}">
                            アイテム取引履歴
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                17
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 1}">
                            登録済みアイテム
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                4
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 2" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 2}">
                            参加したイベント
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                11
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 3" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 3}">
                            主催したイベント
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                2
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 4" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 4}">
                            投稿したリクエスト
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                2
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
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">借用者氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">貸出日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">返却日時</th>
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
                                    <td class="px-6 py-4">
                                        <a href="#" class="hover:text-blue-700">尾関 なな海</a>
                                    </td>
                                    <td class="px-6 py-4 text-right">2023年4月28日 13:09:59</td>
                                    <td class="px-6 py-4 text-right">2023年6月2日 09:44:18</td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#"><x-admin-button-detail></x-admin-button-detail></a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">ゲーミングチェア</th>
                                    <td class="px-6 py-4 text-right">550 pt</td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="hover:text-blue-700">武田 龍一</a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="#" class="hover:text-blue-700">POSSE</a>
                                    </td>
                                    <td class="px-6 py-4 text-right">2023年3月12日 23:09:10</td>
                                    <td class="px-6 py-4 text-right"></td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#"><x-admin-button-detail></x-admin-button-detail></a>
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
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">カテゴリー</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">利用ポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">貸出状況</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ([0, 1, 2] as $item)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">ディスプレイ</th>
                                    <td class="px-6 py-4">
                                        <x-admin-status-basic>PCアクセサリー</x-admin-status-basic>
                                    </td>
                                    <td class="px-6 py-4">
                                        500 pt
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-admin-status-red>貸出中</x-admin-status-red>
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#">
                                            <x-admin-button-detail></x-admin-button-detail>
                                        </a>
                                        <a href="#">
                                            <x-admin-button-edit>ポイント設定して承認</x-admin-button-edit>
                                        </a>
                                        <a href="#">
                                            <x-admin-button-delete></x-admin-button-delete>
                                        </a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">ディスプレイ</th>
                                    <td class="px-6 py-4">
                                        <x-admin-status-basic>PCアクセサリー</x-admin-status-basic>
                                    </td>
                                    <td class="px-6 py-4">
                                        500 pt
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-admin-status-green>貸出可</x-admin-status-green>
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#">
                                            <x-admin-button-detail></x-admin-button-detail>
                                        </a>
                                        <a href="#">
                                            <x-admin-button-edit>ポイント設定して承認</x-admin-button-edit>
                                        </a>
                                        <a href="#">
                                            <x-admin-button-delete></x-admin-button-delete>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div :class="{ '!block': activeTab === 2 }" x-show.transition.in.opacity.duration.600="activeTab === 2" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">イベント名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">カテゴリー</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">参加状況</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">開催日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">参加人数</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">支払いポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ([0, 1, 2] as $item)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">TypeScript勉強会</th>
                                    <td class="px-6 py-4">
                                        <x-admin-status-basic>勉強会</x-admin-status-basic>
                                        <x-admin-status-basic>オンライン</x-admin-status-basic>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-admin-status-green>参加</x-admin-status-green>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        2023年4月30日 13:99:00
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        8 人
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        400 pt
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#">
                                            <x-admin-button-detail></x-admin-button-detail>
                                        </a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">運動会</th>
                                    <td class="px-6 py-4">
                                        <x-admin-status-basic>オフライン</x-admin-status-basic>
                                        <x-admin-status-basic>全体イベント</x-admin-status-basic>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-admin-status-red>キャンセル</x-admin-status-red>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        2023年4月30日 13:99:00
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        8 人
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        400 pt
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#">
                                            <x-admin-button-detail></x-admin-button-detail>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div :class="{ '!block': activeTab === 3 }" x-show.transition.in.opacity.duration.600="activeTab === 3" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">イベント名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">カテゴリー</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-center">開催状況</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">開催日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">参加人数</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">獲得ポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ([0, 1, 2] as $item)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">React勉強会</th>
                                    <td class="px-6 py-4">
                                        <x-admin-status-basic>勉強会</x-admin-status-basic>
                                        <x-admin-status-basic>オンライン</x-admin-status-basic>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <x-admin-status-green>開催前</x-admin-status-green>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        2023年4月30日 13:99:00
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        8 人
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        4500 pt
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#">
                                            <x-admin-button-detail></x-admin-button-detail>
                                        </a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">React勉強会</th>
                                    <td class="px-6 py-4">
                                        <x-admin-status-basic>勉強会</x-admin-status-basic>
                                        <x-admin-status-basic>オンライン</x-admin-status-basic>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <x-admin-status-red>開催終了</x-admin-status-red>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        2023年4月30日 13:99:00
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        8 人
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        2000 pt
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#">
                                            <x-admin-button-detail></x-admin-button-detail>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div :class="{ '!block': activeTab === 4 }" x-show.transition.in.opacity.duration.600="activeTab === 4" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">タイトル</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-center">状況</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">投稿日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ([0, 1, 2] as $item)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">ディスプレイが欲しい</th>
                                    <td class="px-6 py-4 text-center">
                                        <x-admin-status-red>未解決</x-admin-status-red>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        2023年4月30日 13:99:00
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#">
                                            <x-admin-button-detail></x-admin-button-detail>
                                        </a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">Laravelの勉強会を開いてほしい</th>
                                    <td class="px-6 py-4 text-center">
                                        <x-admin-status-green>解決済み</x-admin-status-green>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        2023年5月1日 12:99:00
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="#">
                                            <x-admin-button-detail></x-admin-button-detail>
                                        </a>
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
