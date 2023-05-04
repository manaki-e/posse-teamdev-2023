<x-admin-app>
    <x-slot name="title">
        {{ __('ポイント交換履歴') }}
    </x-slot>
    <x-slot name="discription">
        {{ __('今までに申請されたポイント交換の履歴が表示されます。Amazon Giftカードを送付した場合は『交換完了』ボタンを押してください。') }}
    </x-slot>

    <div class="bg-white shadow rounded-lg md:p-6 w-full">
        <div x-data="{ activeTab: 0 }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 0}">
                            ポイント交換済み履歴
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                41
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 1}">
                            ポイント交換申請
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
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">申請者氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">交換ポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">申請日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">交換日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ([0, 1, 2, 3, 4, 5, 6, 7, 8, 9] as $item)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4">
                                        <a href="#" class="hover:text-blue-700">古屋 美羽</a>
                                    </th>
                                    <td class="px-6 py-4 text-right">3000 pt</td>
                                    <td class="px-6 py-4 text-right">2023年1月2日 06:47:01</td>
                                    <td class="px-6 py-4 text-right">2023年1月31日 19:18:93</td>
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
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">申請者氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">交換ポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">申請日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ([0, 1, 2] as $item)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4">
                                        <a href="#" class="hover:text-blue-700">古屋 美羽</a>
                                    </th>
                                    <td class="px-6 py-4 text-right">3000 pt</td>
                                    <td class="px-6 py-4 text-right">2023年1月2日 06:47:01</td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <div x-data="{ showModal: false }" x-on:keydown.window.escape="showModal = false">
                                            <div class="flex justify-center">
                                                <a href="#" @click="showModal = !showModal"><x-admin-button-edit>交換完了</x-admin-button-edit></a>
                                            </div>
                                            <div x-cloak x-show="showModal" x-transition.opacity class="fixed inset-0 z-10 bg-gray-700/50"></div>
                                            <div x-cloak x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
                                                <div class="mx-auto overflow-hidden rounded-lg bg-white shadow-xl sm:w-full sm:max-w-xl">
                                                    <div class="relative p-6">
                                                        <div class="flex gap-4">
                                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100 text-yellow-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
                                                                </svg>
                                                            </div>
                                                            <div class="flex-1">
                                                                <h3 class="text-lg font-medium text-secondary-900">ポイント交換を完了しましたか？</h3>
                                                                <div class="mt-2 text-sm text-secondary-500">対象のユーザにAmazon Giftカードを受け渡し後に完了を押してください。交換完了後のキャンセルはできません。</div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-6 flex justify-end gap-3">
                                                            <button type="button" @click="showModal = false" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-100 focus:ring focus:ring-gray-100 disabled:cursor-not-allowed disabled:border-gray-100 disabled:bg-gray-50 disabled:text-gray-400">戻る</button>
                                                            <button type="button" class="rounded-lg border border-blue-500 bg-blue-500 px-4 py-2 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-blue-700 hover:bg-blue-700 focus:ring focus:ring-blue-200 disabled:cursor-not-allowed disabled:border-blue-300 disabled:bg-blue-300">交換完了</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
