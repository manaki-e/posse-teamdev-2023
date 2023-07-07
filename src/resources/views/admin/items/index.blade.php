<x-admin-app>
    <x-slot name="title">
        {{ __('アイテム一覧') }}
    </x-slot>
    <x-slot name="description">
        {{ __('登録済みアイテムと登録申請待ちアイテムの一覧が表示されます') }}
    </x-slot>

    <div class="bg-white shadow rounded-lg md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
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
                                    <th scope="col" class="px-3 py-4 font-medium text-gray-900 text-right">ポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">登録者氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-center">貸出状況</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ($not_pending_products as $not_pending_product)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">{{ $not_pending_product -> title }}
                                    </th>
                                    <td class="px-6 py-4 text-right">{{ $not_pending_product -> point }} pt</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.users.show', ['user' => $not_pending_product -> user -> id]) }}" class="border-b border-blue-600 hover:text-blue-700">{{ $not_pending_product -> user -> name }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($not_pending_product -> status === \App\Models\Product::STATUS['available'])
                                        <x-admin-status-green>貸出可能</x-admin-status-green>
                                        @else
                                        <x-admin-status-red>貸出中</x-admin-status-red>
                                        @endif
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <x-admin-button-detail href="{{ route('admin.items.show', ['item' =>  $not_pending_product -> id]) }}">
                                        </x-admin-button-detail>
                                        <x-admin-button-edit action="{{ route('admin.items.update', ['item' =>  $not_pending_product -> id]) }}">
                                            <x-slot name="content">
                                                ポイント再設定
                                            </x-slot>
                                            <x-slot name="modal_title">
                                                ポイント再設定を行いますか？
                                            </x-slot>
                                            <x-slot name="modal_description">
                                                ポイントを再設定すると、アイテムのポイントが変更されます。
                                                <br>
                                                貸出中のアイテムのポイントを編集すると、来月の貸出より新しいポイントが適用されます。
                                            </x-slot>
                                            <x-slot name="method">
                                                @method('PUT')
                                            </x-slot>
                                            <x-slot name="form_slot">
                                                <div class="mb-4">
                                                    <div class="relative flex gap-4">
                                                        <label for="point" class="leading-7 text-sm text-gray-600 flex-center">ポイント:</label>
                                                        <input max="5000" type="number" id="point" name="point" value="{{ $not_pending_product -> point }}" class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    </div>
                                                    <p class="ml-2 text-xs text-gray-500 ">
                                                        ポイントの上限は 5000 pt
                                                    </p>
                                                </div>
                                            </x-slot>
                                        </x-admin-button-edit>
                                        <x-admin-button-delete action="{{ route('admin.items.destroy', ['item' =>  $not_pending_product -> id]) }}">
                                            <x-slot name="modal_title">
                                                {{ $not_pending_product -> title }}を削除しますか？
                                            </x-slot>
                                            <x-slot name="modal_description">
                                                対象のアイテムを削除します。削除したアイテムは元に戻せません。
                                            </x-slot>
                                        </x-admin-button-delete>
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
                                        <a href="{{ route('admin.users.show', ['user' => $pending_product -> user -> id]) }}" class="border-b border-blue-600 hover:text-blue-700">{{ $pending_product -> user -> name }}</a>
                                    </td>
                                    <td class=" px-6 py-4">
                                        {{ date( 'Y年m月d日 H時i分s秒', strtotime( $pending_product -> created_at ) ) }}
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <x-admin-button-detail href="{{ route('admin.items.show', ['item' =>  $pending_product -> id]) }}">
                                        </x-admin-button-detail>
                                        <x-admin-button-edit action="{{ route('admin.items.update', ['item' =>  $pending_product -> id]) }}">
                                            <x-slot name="content">
                                                ポイントを設定して承認する
                                            </x-slot>
                                            <x-slot name="modal_title">
                                                ポイントを設定して承認する
                                            </x-slot>
                                            <x-slot name="modal_description">
                                                ポイントを設定すると、アイテムが登録され、誰でも借りることができるようになります。また、ポイントはいつでも変更することができます。
                                            </x-slot>
                                            <x-slot name="method">
                                                @method('PUT')
                                            </x-slot>
                                            <x-slot name="form_slot">
                                                <div class="mb-4">
                                                    <div class="relative flex gap-4">
                                                        <label for="point" class="leading-7 text-sm text-gray-600 flex-center">Point:</label>
                                                        <input max="5000" type="number" id="point" name="point" class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required>
                                                    </div>
                                                    <p class="ml-2 text-xs text-gray-500 ">
                                                        ポイントの上限は 5000 pt
                                                    </p>
                                                </div>
                                            </x-slot>
                                        </x-admin-button-edit>
                                        <x-admin-button-delete action="{{ route('admin.items.destroy', ['item' =>  $pending_product -> id]) }}">
                                            <x-slot name="modal_title">
                                                {{ $pending_product -> title }}を削除しますか？
                                            </x-slot>
                                            <x-slot name="modal_description">
                                                対象のユーザをPeerPerkのユーザから削除します。ここで削除されたユーザはslackに所属している限り、再度登録することができます。
                                            </x-slot>
                                        </x-admin-button-delete>
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
