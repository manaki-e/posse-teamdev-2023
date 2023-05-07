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
                    <!-- 後ほど編集する -->
                    <img class="rounded-full overflow-hidden border-4 admin-border-green" src="{{ asset('images/sample_product_1.jpeg') }}" alt="ユーザ写真">
                </div>
            </div>
            <div>
                <div class="my-4">
                    <p class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">{{ $user_data -> name }}</p>
                    <div class="h-1 w-40 bg-indigo-500 rounded"></div>
                </div>
                <div>
                    <ul class="flex flex-col gap-2 p-0">
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">Email:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">{{ $user_data -> email }}</p>
                        </li>
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">所属部署:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">{{ $user_data -> department -> name }}</p>
                        </li>
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">Role:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-500">
                                {{ $user_data -> is_admin === 1 ? '管理者' : '一般ユーザ' }}
                            </p>
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
                            <!-- 後ほど編集する -->
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
                            <!-- 後ほど編集する -->
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
                            {{ $user_data -> earned_point }}
                        </x-slot>
                        <x-slot name="discription">
                            {{ __('今月獲得ポイント') }}
                        </x-slot>
                    </x-admin-point>
                </div>
                <div class="p-4 w-1/4">
                    <x-admin-point>
                        <x-slot name="point">
                            {{ 5000 - $user_data -> distribution_point }}
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
                                {{ $product_deal_logs -> total() }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 1}">
                            登録済みアイテム
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $products -> total() }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 2" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 2}">
                            参加したイベント
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $joined_event_logs -> total() }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 3" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 3}">
                            主催したイベント
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $held_events -> total() }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 4" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 4}">
                            投稿したリクエスト
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $requests -> total() }}
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
                                @foreach ( $product_deal_logs as $product_deal_log )
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">{{ $product_deal_log -> product -> title }}</th>
                                    <td class="px-6 py-4 text-right">{{ $product_deal_log -> product -> point }} pt</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.users.show', ['user' => $product_deal_log -> product -> user -> id]) }}" class="border-b border-blue-600 hover:text-blue-700">{{ $product_deal_log -> product -> user -> name }}</a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.users.show', ['user' => $product_deal_log -> user -> id]) }}" class="border-b border-blue-600 hover:text-blue-700">{{ $product_deal_log -> user -> name }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ date( 'Y年m月d日 H時i分s秒', strtotime( $product_deal_log -> created_at ) ) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ $product_deal_log -> returned_at
                                        ? date( 'Y年m月d日 H時i分s秒', strtotime( $product_deal_log -> returned_at ) )
                                        : '貸出中' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $product_deal_logs->withPath(url('/admin/users/'.$user.'?activeTab=0'))->links() }}
                </div>
                <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">商品名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">カテゴリー</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">利用ポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">いいね数</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">貸出状況</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ( $products as $product )
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">{{ $product -> title }}</th>
                                    <td class="px-6 py-4">
                                        @foreach ( $product -> productTags as $product_tag )
                                        <x-admin-status-basic>{{ $product_tag -> tag -> name }}</x-admin-status-basic>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product -> point }} pt
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product -> product_likes_count }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ( $product -> status === 3 )
                                        <x-admin-status-red>貸出中</x-admin-status-red>
                                        @else
                                        <x-admin-status-green>貸出可能</x-admin-status-green>
                                        @endif
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <x-admin-button-detail href="{{ route('admin.items.show', ['item' =>  $product -> id]) }}"></x-admin-button-detail>
                                        <!-- 後ほど編集する -->
                                        <x-admin-button-edit action="">
                                            <x-slot name="content">
                                                ポイント再設定
                                            </x-slot>
                                            <x-slot name="modal_title">
                                                ポイント再設定
                                            </x-slot>
                                            <x-slot name="modal_description">
                                                ポイントを再設定すると、アイテムのポイントが変更されます。
                                                <br>
                                                貸出中のアイテムのポイントを編集すると、来月の貸出より新しいポイントが適用されます。
                                            </x-slot>
                                        </x-admin-button-edit>
                                        <x-admin-button-delete action="{{ route('admin.items.destroy', ['item' =>  $product -> id]) }}"></x-admin-button-delete>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $products->withPath(url('/admin/users/'.$user.'?activeTab=1'))->links() }}
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
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">支払いポイント</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ( $joined_event_logs as $event_log )
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">{{ $event_log -> event -> title }}</th>
                                    <td class="px-6 py-4">
                                        @foreach ( $event_log -> event -> eventTags as $event_log_tag )
                                        <x-admin-status-basic>{{ $event_log_tag -> tag -> name }}</x-admin-status-basic>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ( $event_log -> deleted_at )
                                        <x-admin-status-red>キャンセル済み</x-admin-status-red>
                                        @else
                                        <x-admin-status-green>参加</x-admin-status-green>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ $event_log -> event -> date
                                        ? date( 'Y年m月d日 H時i分s秒', strtotime( $event_log -> event -> date ) )
                                        : '未定' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ $event_log -> point }} pt
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <!-- 後ほど修正する -->
                                        <x-admin-button-detail href="#"></x-admin-button-detail>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $joined_event_logs->withPath(url('/admin/users/'.$user.'?activeTab=2'))->links() }}
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
                                @foreach ( $held_events as $event )
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">{{ $event -> title }}</th>
                                    <td class="px-6 py-4">
                                        @foreach ( $event -> eventTags as $event_tag )
                                        <x-admin-status-basic>{{ $event_tag -> tag -> name }}</x-admin-status-basic>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ( $event -> deleted_at )
                                        <x-admin-status-red>開催キャンセル</x-admin-status-red>
                                        @elseif ( $event -> completed_at )
                                        <x-admin-status-basic>開催終了</x-admin-status-basic>
                                        @else
                                        <x-admin-status-green>開催前</x-admin-status-green>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ $event -> date
                                        ? date( 'Y年m月d日 H時i分s秒', strtotime( $event -> date ) )
                                        : '未定' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ $event -> participants_count }} 人
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ $event -> participants_sum_point
                                        ? $event -> participants_sum_point
                                        : 0 }}
                                        pt
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <!-- 後ほど修正する -->
                                        <x-admin-button-detail href="#"></x-admin-button-detail>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $held_events->withPath(url('/admin/users/'.$user.'?activeTab=3'))->links() }}
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
                                @foreach ( $requests as $request )
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 font-medium text-gray-900">{{ $request -> title }}</th>
                                    <td class="px-6 py-4 text-center">
                                        @if ( $request -> completed_at )
                                        <x-admin-status-red>解決済み</x-admin-status-red>
                                        @else
                                        <x-admin-status-green>未解決</x-admin-status-green>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ date( 'Y年m月d日 H時i分s秒', strtotime( $request -> created_at ) ) }}
                                    </td>
                                    <td class="flex justify-end gap-4 px-6 py-4 font-medium">
                                        <!-- 後ほど修正する -->
                                        <x-admin-button-detail></x-admin-button-detail>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $requests->withPath(url('/admin/users/'.$user.'?activeTab=4'))->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-app>
