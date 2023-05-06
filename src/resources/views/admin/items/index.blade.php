<x-admin-app>
    <x-slot name="title">
        {{ __('アイテム一覧') }}
    </x-slot>
    <x-slot name="discription">
        {{ __('登録済みアイテムと登録申請待ちアイテムの一覧が表示されます') }}
    </x-slot>

    <div class="bg-white shadow rounded-lg md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <script>
                Alpine.store('activeTab', "{{ request()->query('activeTab ', 0) }}");
                Alpine.start();
            </script>
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 0}">
                            登録済みアイテム
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $not_pending_products->total() }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 1}">
                            登録申請対応待ちアイテム
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $pending_products->total() }}
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
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">登録者氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-center">貸出状況</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ($not_pending_products as $not_pending_product)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">{{ $not_pending_product -> title }}</th>
                                    <td class="px-6 py-4 text-right">{{ $not_pending_product -> point }} pt</td>
                                    <td class="px-6 py-4">
                                        <a href="/admin/users/{{ $not_pending_product -> user_id }}" class="border-b border-blue-600 hover:text-blue-700"> {{ $not_pending_product -> user -> name }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {!! $not_pending_product -> status === "occupied"
                                        ?
                                        '<span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                            </svg>
                                            貸出中
                                        </span>'
                                        :
                                        '<span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                            </svg>
                                            貸出可能
                                        </span>'
                                        !!}
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <a href="/admin/items/{{ $not_pending_product -> id }}">
                                            <x-admin-button-detail></x-admin-button-detail>
                                        </a>
                                        <a href="/admin/items/{{ $not_pending_product -> id }}/edit">
                                            <x-admin-button-edit>ポイント再設定</x-admin-button-edit>
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

                    {{ $not_pending_products->withPath(url('/admin/items'))->links() }}

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
                                @foreach ($pending_products as $pending_product)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">{{ $pending_product -> title }}</th>
                                    <td class="px-6 py-4">
                                        <a href="#" class="hover:text-blue-700">{{ $pending_product -> user -> name }}</a>
                                    </td>
                                    <td class=" px-6 py-4">
                                        {{ date( 'Y年m月d日 H時i分s秒', strtotime( $pending_product -> created_at ) ) }}
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

                    {{ $pending_products->withPath(url('/admin/items?activeTab=1'))->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-app>
