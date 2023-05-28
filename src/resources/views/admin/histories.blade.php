<x-admin-app>
    <x-slot name="title">
        {{ __('取引履歴') }}
    </x-slot>
    <x-slot name="description">
        {{ __('アイテムの貸し出しまたはイベントの参加登録によって生じたポイントの移行履歴が表示されます') }}
    </x-slot>

    <div class="bg-white shadow rounded-lg md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 0}">
                            アイテム取引
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $product_deals->total() }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 1}">
                            イベント参加
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $event_participants->total() }}
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
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ( $product_deals as $product_deal )
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.items.show', ['item' => $product_deal -> product -> id]) }}" class="border-b border-blue-600 hover:text-blue-700">{{ $product_deal -> product -> title }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-right">{{ $product_deal -> product -> point }} pt</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.users.show', ['user' => $product_deal -> user -> id]) }}" class="border-b border-blue-600 hover:text-blue-700">{{ $product_deal -> user -> name }}</a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.users.show', ['user' => $product_deal -> product -> user -> id]) }}" class="border-b border-blue-600 hover:text-blue-700">{{ $product_deal -> product -> user -> name }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ date( 'Y年m月d日 H時i分s秒', strtotime( $product_deal -> created_at ) ) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ $product_deal -> returned_at
                                        ? date( 'Y年m月d日 H時i分s秒', strtotime( $product_deal -> returned_at ) )
                                        : '未返却' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $product_deals->withPath(url('/admin/histories'))->links() }}
                </div>
                <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">イベント名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">参加登録者氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">参加 pt</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">申請日時</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ( $event_participants as $event_participant )
                                <tr class="hover:bg-gray-50">
                                    <!-- 後ほど修正する -->
                                    <th class="px-6 py-4 font-medium text-gray-900">{{ $event_participant -> event -> title }}</th>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.users.show', ['user' => $event_participant -> user -> id]) }}" class="border-b border-blue-600 hover:text-blue-700">{{ $event_participant -> user -> name }}</a>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 text-right">{{ $event_participant -> point }} pt</td>
                                    <td class=" px-6 py-4 text-right">
                                        {{ date( 'Y年m月d日 H時i分s秒', strtotime( $event_participant -> created_at ) ) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $event_participants->withPath(url('/admin/histories?activeTab=1'))->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-app>
