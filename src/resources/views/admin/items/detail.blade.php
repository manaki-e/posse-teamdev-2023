<x-admin-app>
    <x-slot name="title">
        {{ __('アイテム詳細') }}
    </x-slot>
    <x-slot name="discription">
        {{ __('特定のアイテムに関するデータ（アイテム詳細・アイテム取引履歴）が表示されます。') }}
    </x-slot>

    <div class="bg-white shadow rounded-lg md:p-6 w-full my-4">
        <nav class="flex mx-auto max-w-screen-xl px-4 md:px-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-lg text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        アイテム一覧
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-lg text-gray-500 md:ml-2 dark:text-gray-400">アイテム詳細</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex gap-4 py-4">
            <div class="w-1/3" x-data="{ activeImage: 0 }">
                <div class="w-full mb-4">
                    <ul class="flex gap-2">
                        <li class="w-1/4 flex-center">
                            <div @click="activeImage = activeImage + 2" class="rounded-full overflow-hidden bg-gray-200 p-3 cursor-pointer hover:scale-125">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </div>
                        </li>
                        <li class="">
                            @foreach ( $product -> productImages as $product_image )
                            <div :class="{ '!block': activeImage % {{ count($product -> productImages) }} === {{ $loop->index }} }" x-show.transition.in.opacity.duration.600="activeImage % {{ count($product -> productImages) }} === {{ $loop->index }}" class="hidden">
                                <img src="{{ asset('images/'.$product_image->image_url) }}" alt="アイテム写真">
                            </div>
                            @endforeach
                        </li>
                        <li class="w-1/4 flex-center">
                            <div @click="activeImage = activeImage + 1" class="rounded-full overflow-hidden bg-gray-200 p-3 cursor-pointer hover:scale-125">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul class="flex gap-1">
                        @foreach ( $product -> productImages as $product_image )
                        <li class="w-1/4 aspect-square border border-black">
                            <img src="{{ asset('images/'.$product_image->image_url) }}" alt="アイテム写真">
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="w-2/3">
                <div class="my-4">
                    <div class="flex justify-between w-full">
                        <p class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">{{ $product -> title }}</p>
                        @if ($product -> status === 3)
                        <x-admin-status-red>貸出中</x-admin-status-red>
                        @elseif ($product -> status === 2)
                        <x-admin-status-green>貸出可能</x-admin-status-green>
                        @endif
                    </div>
                    <div class="h-1 w-40 bg-indigo-500 rounded"></div>
                    <div class="mt-2">
                        @foreach ( $product -> productTags as $product_tag )
                        <x-admin-status-basic>{{ $product_tag -> tag -> name }}</x-admin-status-basic>
                        @endforeach
                    </div>
                </div>
                <div>
                    <ul class="flex flex-col gap-2 p-0">
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">アイテム説明:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-gray-500">{{ $product -> description }}</p>
                        </li>
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">利用ポイント:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-gray-500">{{ $product -> point }} pt</p>
                        </li>
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">作成日時:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-gray-500">
                                {{ date( 'Y年m月d日 H時i分s秒', strtotime( $product -> created_at ) ) }}
                            </p>
                        </li>
                        @if ( $product -> deleted_at )
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">削除日時:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-gray-500">
                                {{ date( 'Y年m月d日 H時i分s秒', strtotime( $product -> deleted_at ) ) }}
                            </p>
                        </li>
                        @endif
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">リクエストの紐付け:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-gray-500">
                                <!-- 後ほど修正する -->
                                {!! ( $product -> request )
                                ? 'あり <a href="#" class="hover:text-blue-700 border-b border-blue-800">（ここを押すと紐づけられたリクエストの詳細に飛びます）</a>'
                                : 'なし' !!}
                            </p>
                        </li>
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">お気に入りの数:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-gray-500">{{ $product -> product_likes_count }}</p>
                        </li>
                        <li class="flex items-center gap-4 pl-4">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-semibold capitalize">貸出者:</p>
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-gray-500">
                                <a href="{{ route('admin.users.show', ['user' => $product -> user -> id]) }}" class="hover:text-blue-700 border-b border-blue-600">{{ $product -> user -> name }}</a>
                            </p>
                        </li>
                        <li class="flex items-center gap-4 pl-4 mt-4">
                            <!-- 後ほど修正する -->
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
                        </li>
                    </ul>
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
                            貸出履歴
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $product_deals -> total() }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class=" py-3">
                <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">借用者氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">貸出日時</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">返却日時</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ( $product_deals as $deal )
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.users.show', ['user' => $deal -> user -> id]) }}" class="hover:text-blue-700 border-b border-blue-600">{{ $deal -> user -> name }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ date( 'Y年m月d日 H時i分s秒', strtotime( $deal -> created_at ) ) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ $deal -> returned_at
                                        ? date( 'Y年m月d日 H時i分s秒', strtotime( $deal -> returned_at ) )
                                        : '未返却' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $product_deals->withPath(url('/admin/items/'.$product->id))->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-app>
