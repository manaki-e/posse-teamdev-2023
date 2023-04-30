<x-admin-app>
    <x-slot name="title">
        {{ __('ユーザー一覧') }}
    </x-slot>
    <x-slot name="discription">
        {{ __('APのslackワークスペースに所属しており、メールアドレスが@anti-pattern.co.jpであるユーザーの一覧が表示されます') }}
    </x-slot>

    <div class="bg-white shadow rounded-lg md:p-6 w-full">
        <div x-data="{ activeTab: 0 }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{
                                'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab ===
                                    0
                            }">
                            ユーザー一覧
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                68
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="py-3">
                <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 ">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">メールアドレス</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">所属部署</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">所持ポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">獲得ポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ([0,1,2,3,4,5] as $user)
                                <tr class="hover:bg-gray-50">
                                    <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
                                        <div class="relative h-10 w-10">
                                            <img class="h-full w-full rounded-full object-cover object-center" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                            <span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
                                        </div>
                                        <div class="text-sm flex-center">
                                            <div class="font-medium text-gray-700">五十嵐 佳貴</div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">manaki_nhk@keio.jp</td>
                                    <td class="px-6 py-4">エンジニア</td>
                                    <td class="px-6 py-4 text-right">500 pt</td>
                                    <td class="px-6 py-4 text-right">1050 pt</td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-4">
                                            <a href="#"><x-admin-button-detail></x-admin-button-detail></a>
                                            <a href="#"><x-admin-button-delete></x-admin-button-delete></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
                                        <div class="relative h-10 w-10">
                                            <img class="h-full w-full rounded-full object-cover object-center" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                            <span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-pink-400 ring ring-white"></span>
                                        </div>
                                        <div class="text-sm flex-center">
                                            <div class="font-medium text-gray-700">本城 裕大</div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">manaki.endou@anti-pattern.co.jp</td>
                                    <td class="px-6 py-4">営業部</td>
                                    <td class="px-6 py-4 text-right">5000 pt</td>
                                    <td class="px-6 py-4 text-right">500 pt</td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-4">
                                            <a href="#"><x-admin-button-detail></x-admin-button-detail></a>
                                            <a href="#"><x-admin-button-delete></x-admin-button-delete></a>
                                        </div>
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
            </div>
        </div>
    </div>
</x-admin-app>
