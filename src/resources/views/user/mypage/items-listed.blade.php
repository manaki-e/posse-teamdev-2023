<x-mypage-app>
    <x-slot:border_color>border-blue-400</x-slot:border_color>
    <x-slot:title>出品したアイテム一覧</x-slot:title>
    <x-slot:earned_point>{{ Auth::user()->earned_point }}</x-slot:earned_point>
    <x-slot:distribution_point>{{ Auth::user()->distribution_point }}</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-400 hover:text-blue-400" :class="{'relative text-blue-400  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-400': activeTab === 0}">
                            出品中
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-400 hover:text-blue-400" :class="{'relative text-blue-400  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-400': activeTab === 1}">
                            貸出中
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 2" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-400 hover:text-blue-400" :class="{'relative text-blue-400  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-400': activeTab === 2}">
                            登録申請中
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                    <ul class="border-b border-gray-300">
                        @foreach ($lendable_products as $product)
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('items.show', ['item' =>  $product -> id]) }}" class="block w-full h-full cursor-pointer">
                                <x-mypage-item-list>
                                    <x-slot:image_url>{{ $product -> productImages[0] -> image_url }}</x-slot:image_url>
                                    <x-slot:title>{{ $product -> title }}</x-slot:title>
                                    <x-slot:point>{{ empty( $product -> point ) ? '未設定' : $product->point .' pt'}}</x-slot:point>
                                    <x-slot:tag>
                                        @foreach ($product->productTags as $tag)
                                        <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                        @endforeach
                                    </x-slot:tag>
                                    <x-slot:button></x-slot:button>
                                    <div x-data=" { showModal: false }" x-on:keydown.window.escape="showModal = false" class="absolute top-0 right-0">
                                        <div class="flex justify-center">
                                            <a @click="showModal = !showModal">
                                                <button class="middle none center font-sans py-3 px-2 text-xs font-bold uppercase text-gray-700 transition-all hover:opacity-75 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-dark="true">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                    </svg>
                                                </button>
                                            </a>
                                        </div>
                                        <ul x-cloak x-show="showModal" x-transitio class="absolute z-10 w-28 overflow-auto rounded-md border border-blue-gray-50 bg-white font-sans text-sm font-normal text-blue-gray-500 shadow-lg shadow-blue-gray-500/10 focus:outline-none">
                                            <li role="menuitem" class="hover:bg-gray-300 block w-full cursor-pointer select-none px-3 py-4 text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
                                                <x-mypage-button-edit href="{{ route('items.edit', ['item' =>  $product -> id]) }}"></x-mypage-button-edit>
                                            </li>
                                            <li role="menuitem" class="hover:bg-gray-300 block w-full cursor-pointer select-none px-3 py-4 text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
                                                <x-mypage-button-delete action="{{ route('items.destroy', ['item' =>  $product -> id]) }}">
                                                    <x-slot name="modal_title">
                                                        {{ $product -> title }}を削除しますか？
                                                    </x-slot>
                                                    <x-slot name="modal_description">
                                                        対象のイベントを削除します。一度削除すると復元できません。
                                                    </x-slot>
                                                </x-mypage-button-delete>
                                            </li>
                                        </ul>
                                    </div>
                                </x-mypage-item-list>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                    <ul class="border-b border-gray-300">
                        @foreach ($borrowed_products as $product)
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('items.show', ['item' =>  $product -> id]) }}" class="block w-full h-full cursor-pointer">
                                <x-mypage-item-list>
                                    <x-slot:product_id>{{ $product -> id }}</x-slot:product_id>
                                    <x-slot:image_url>{{ $product -> productImages[0] -> image_url }}</x-slot:image_url>
                                    <x-slot:title>{{ $product -> title }}</x-slot:title>
                                    <x-slot:point>{{ empty( $product -> point ) ? '未設定' : $product->point .' pt'}}</x-slot:point>
                                    <x-slot:tag>
                                        @foreach ($product->productTags as $tag)
                                        <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                        @endforeach
                                    </x-slot:tag>
                                    <x-slot:button>
                                        <div class="whitespace-nowrap flex flex-col gap-2">
                                            @if ($product -> status === \App\Models\Product::STATUS['delivering'])
                                            <x-mypage-button-item-cancel action="{{ route('items.cancel', ['item' =>  $product -> id]) }}">
                                                <x-slot name="content">
                                                    貸出キャンセル
                                                </x-slot>
                                                <x-slot:logo_path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                                </x-slot:logo_path>
                                                <x-slot name="modal_title">
                                                    アイテムの貸出をキャンセルする
                                                </x-slot>
                                                <x-slot name="modal_description">
                                                    この操作はアイテムを配送する前に行ってください。貸出をキャンセルすると、アイテムの貸出がキャンセルされ、貸出可の状態になります。
                                                </x-slot>
                                                <x-slot name="method"></x-slot>
                                                <x-slot name="form_slot"></x-slot>
                                            </x-mypage-button-item-cancel>
                                            @elseif ($product -> status === \App\Models\Product::STATUS['occupied'])
                                            <x-mypage-button-item-receive action="{{ route('items.return', ['item' =>  $product -> id]) }}">
                                                <x-slot name="content">
                                                    受取完了
                                                </x-slot>
                                                <x-slot:logo_path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m-6 3.75l3 3m0 0l3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
                                                </x-slot:logo_path>
                                                <x-slot name="modal_title">
                                                    貸出したアイテムの受取完了
                                                </x-slot>
                                                <x-slot name="modal_description">
                                                    この操作はアイテムを受取した後に行ってください。受取完了すると、アイテムの貸出が完了し、貸出可の状態になります。
                                                </x-slot>
                                                <x-slot name="method"></x-slot>
                                                <x-slot name="form_slot"></x-slot>
                                                </x-mypage-but-item-receive>
                                                @endif
                                        </div>
                                    </x-slot:button>
                                </x-mypage-item-list>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div :class="{ '!block': activeTab === 2 }" x-show.transition.in.opacity.duration.600="activeTab === 2" class="hidden">
                    <ul class="border-b border-gray-300">
                        @foreach ($applying_products as $product)
                        <li class="hover:bg-gray-100">
                            <a href="{{ route('items.show', ['item' =>  $product -> id]) }}" class="block w-full h-full cursor-pointer">
                                <x-mypage-item-list>
                                    <x-slot:product_id>{{ $product -> id }}</x-slot:product_id>
                                    <x-slot:image_url>{{ $product -> productImages[0] -> image_url }}</x-slot:image_url>
                                    <x-slot:title>{{ $product -> title }}</x-slot:title>
                                    <x-slot:point></x-slot:point>
                                    <x-slot:tag>
                                        @foreach ($product->productTags as $tag)
                                        <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                        @endforeach
                                    </x-slot:tag>
                                    <x-slot:button></x-slot:button>
                                    <div x-data=" { showModal: false }" x-on:keydown.window.escape="showModal = false" class="absolute top-0 right-0">
                                        <div class="flex justify-center">
                                            <a @click="showModal = !showModal">
                                                <button class="middle none center font-sans py-3 px-2 text-xs font-bold uppercase text-gray-700 transition-all hover:opacity-75 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-dark="true">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                    </svg>
                                                </button>
                                            </a>
                                        </div>
                                        <ul x-cloak x-show="showModal" x-transitio class="absolute z-10 w-28 overflow-auto rounded-md border border-blue-gray-50 bg-white font-sans text-sm font-normal text-blue-gray-500 shadow-lg shadow-blue-gray-500/10 focus:outline-none">
                                            <li role="menuitem" class="hover:bg-gray-300 block w-full cursor-pointer select-none px-3 py-4 text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
                                                <x-mypage-button-edit href="{{ route('items.edit', ['item' =>  $product -> id]) }}"></x-mypage-button-edit>
                                            </li>
                                            <li role="menuitem" class="hover:bg-gray-300 block w-full cursor-pointer select-none px-3 py-4 text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
                                                <x-mypage-button-delete action="{{ route('items.destroy', ['item' =>  $product -> id]) }}">
                                                    <x-slot name="modal_title">
                                                        {{ $product -> title }}を削除しますか？
                                                    </x-slot>
                                                    <x-slot name="modal_description">
                                                        対象のイベントを削除します。一度削除すると復元できません。
                                                    </x-slot>
                                                </x-mypage-button-delete>
                                            </li>
                                        </ul>
                                    </div>
                                </x-mypage-item-list>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-mypage-app>
