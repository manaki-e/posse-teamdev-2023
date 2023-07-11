<x-admin-app>
    <x-slot name="title">
        {{ __('ポイント交換履歴') }}
    </x-slot>
    <x-slot name="description">
        {{ __('今までに申請されたポイント交換の履歴が表示されます。Amazon Giftカードを送付した場合は『交換完了』ボタンを押してください。') }}
    </x-slot>

    <div class="bg-white shadow rounded-lg md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 0}">
                            ポイント交換済み履歴
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $done_point_exchanges->total() }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 1}">
                            ポイント交換申請
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $undone_point_exchanges->total() }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="py-3">
                <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50 whitespace-nowrap">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">申請者氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">交換ポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">申請日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">交換完了日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ( $done_point_exchanges as $done_point_exchange )
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4">
                                        <a href="{{ route('admin.users.show', ['user' => $done_point_exchange -> user -> id]) }}" class="border-b border-blue-600 hover:text-blue-700">{{ $done_point_exchange -> user -> name }}</a>
                                    </th>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">{{ $done_point_exchange -> point }} pt</td>
                                    <td class="px-6 py-4 text-right">
                                        {{ date( 'Y年m月d日 H時i分s秒', strtotime( $done_point_exchange -> created_at ) ) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ date( 'Y年m月d日 H時i分s秒', strtotime( $done_point_exchange -> updated_at ) ) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $done_point_exchanges->withPath(url('/admin/point-exchanges'))->links() }}
                </div>
                <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50 whitespace-nowrap">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">申請者氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">交換ポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">申請日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ( $undone_point_exchanges as $undone_point_exchange )
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4">
                                        <a href="{{ route('admin.users.show', ['user' => $undone_point_exchange -> user -> id]) }}" class="border-b border-blue-600 hover:text-blue-700">{{ $undone_point_exchange -> user -> name }}</a>
                                    </th>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">{{ $undone_point_exchange -> point }} pt</td>
                                    <td class="px-6 py-4 text-right">
                                        {{ date( 'Y年m月d日 H時i分s秒', strtotime( $undone_point_exchange -> created_at ) ) }}
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium whitespace-nowrap">
                                        <x-admin-button-edit action="{{ route('point-exchanges.update-approved', ['id'=> $undone_point_exchange -> id]) }}">
                                            <x-slot name="content">
                                                交換完了
                                            </x-slot>
                                            <x-slot name="modal_title">
                                                ポイント交換を完了しましたか？
                                            </x-slot>
                                            <x-slot name="modal_description">
                                                対象のユーザにAmazon Giftカードを受け渡し後に完了を押してください。交換完了後のキャンセルはできません。
                                            </x-slot>
                                            <x-slot name="method">@method('PUT')</x-slot>
                                            <x-slot name="form_slot"></x-slot>
                                        </x-admin-button-edit>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $undone_point_exchanges->withPath(url('/admin/point-exchanges?activeTab=1'))->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-app>
