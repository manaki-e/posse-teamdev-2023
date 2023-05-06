<x-admin-app>
    <x-slot name="title">
        {{ __('ポイント交換履歴') }}
    </x-slot>
    <x-slot name="discription">
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
                            <thead class="bg-gray-50">
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
                                        <a href="/admin/users/{{ $done_point_exchange -> user -> user_id }}" class="hover:text-blue-700">{{ $done_point_exchange -> user -> name }}</a>
                                    </th>
                                    <td class="px-6 py-4 text-right">{{ $done_point_exchange -> point }} pt</td>
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
                            <thead class="bg-gray-50">
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
                                        <a href="/admin/users/{{ $undone_point_exchange -> user -> user_id }}<" class="hover:text-blue-700">{{ $undone_point_exchange -> user -> name }}</a>
                                    </th>
                                    <td class="px-6 py-4 text-right">{{ $undone_point_exchange -> point }} pt</td>
                                    <td class="px-6 py-4 text-right">
                                        {{ date( 'Y年m月d日 H時i分s秒', strtotime( $done_point_exchange -> created_at ) ) }}
                                    </td>

                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <div x-data="{ showModal: false }" x-on:keydown.window.escape="showModal = false">
                                            <div class="flex justify-center">
                                                <a @click="showModal = true"><x-admin-button-edit>交換完了</x-admin-button-edit></a>
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
                                                            <button @click="showModal = false" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-100 focus:ring focus:ring-gray-100 disabled:cursor-not-allowed disabled:border-gray-100 disabled:bg-gray-50 disabled:text-gray-400">戻る</button>
                                                            <form action="{{ route('point-exchanges.update-approved', ['id' =>  $undone_point_exchange -> id]) }}" method="post">
                                                                @method('PATCH')
                                                                <button type="submit" class="rounded-lg border border-blue-500 bg-blue-500 px-4 py-2 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-blue-700 hover:bg-blue-700 focus:ring focus:ring-blue-200 disabled:cursor-not-allowed disabled:border-blue-300 disabled:bg-blue-300">交換完了</button>
                                                                @csrf
                                                            </form>
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

                    {{ $undone_point_exchanges->withPath(url('/admin/point-exchanges?activeTab=1'))->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-app>
