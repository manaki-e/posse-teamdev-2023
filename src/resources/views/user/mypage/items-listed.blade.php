<x-mypage-app>
    <x-slot:title>出品したアイテム一覧</x-slot:title>
    <x-slot:earned_point>580</x-slot:earned_point>
    <x-slot:distribution_point>5000</x-slot:distribution_point>

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
                        <li>
                            <x-mypage-item-list>
                                <x-slot:image_url>{{ $product -> productImages[0] -> image_url }}</x-slot:image_url>
                                <x-slot:title>{{ $product -> title }}</x-slot:title>
                                <x-slot:point>{{ empty( $product -> point ) ? '未設定' : $product->point .' pt'}}</x-slot:point>
                                <x-slot:likes>{{ count($product -> productLikes) }}</x-slot:likes>
                                <x-slot:tag>
                                    @foreach ($product->productTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                                <x-slot:button>
                                    <x-mypage-button-detail href="{{ route('items.show', ['item' =>  $product -> id]) }}"></x-mypage-button-detail>
                                    <x-mypage-button-edit href="{{ route('items.edit', ['item' =>  $product -> id]) }}"></x-mypage-button-edit>
                                    <x-mypage-button-delete action="{{ route('items.destroy', ['item' =>  $product -> id]) }}">
                                        <x-slot name="modal_title">
                                            {{ $product -> title }}を削除しますか？
                                        </x-slot>
                                        <x-slot name="modal_description">
                                            対象のアイテムを削除します。一度削除すると復元できません。
                                        </x-slot>
                                    </x-mypage-button-delete>
                                </x-slot:button>
                            </x-mypage-item-list>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                    <ul class="border-b border-gray-300">
                        <li>
                            @foreach ($borrowed_products as $product)
                        <li>
                            <x-mypage-item-list>
                                <x-slot:image_url>{{ $product -> productImages[0] -> image_url }}</x-slot:image_url>
                                <x-slot:title>{{ $product -> title }}</x-slot:title>
                                <x-slot:point>{{ empty( $product -> point ) ? '未設定' : $product->point .' pt'}}</x-slot:point>
                                <x-slot:likes>{{ count($product -> productLikes) }}</x-slot:likes>
                                <x-slot:tag>
                                    @foreach ($product->productTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                                <x-slot:button>
                                    <x-mypage-button-detail href="{{ route('items.show', ['item' =>  $product -> id]) }}"></x-mypage-button-detail>
                                    @if ($product -> status === \App\Models\Product::STATUS['delivering'])
                                    <x-mypage-button-status href="{{ route('items.cancel', ['item' =>  $product -> id]) }}">
                                        <x-slot name="content">
                                            貸出キャンセル
                                        </x-slot>
                                        <x-slot name="modal_title">
                                            アイテムの貸出をキャンセルする
                                        </x-slot>
                                        <x-slot name="modal_description">
                                            この操作はアイテムを配送する前に行ってください。貸出をキャンセルすると、アイテムの貸出がキャンセルされ、貸出可の状態になります。
                                        </x-slot>
                                        <x-slot name="method"></x-slot>
                                        <x-slot name="form_slot"></x-slot>
                                    </x-mypage-button-status>
                                    @elseif ($product -> status === \App\Models\Product::STATUS['occupied'])
                                    <x-mypage-button-status href="{{ route('items.return', ['item' =>  $product -> id]) }}">
                                        <x-slot name="content">
                                            受取完了
                                        </x-slot>
                                        <x-slot name="modal_title">
                                            貸出したアイテムの受取完了
                                        </x-slot>
                                        <x-slot name="modal_description">
                                            この操作はアイテムを受取した後に行ってください。受取完了すると、アイテムの貸出が完了し、貸出可の状態になります。
                                        </x-slot>
                                        <x-slot name="method"></x-slot>
                                        <x-slot name="form_slot"></x-slot>
                                    </x-mypage-button-status>
                                    @endif
                                </x-slot:button>
                            </x-mypage-item-list>
                        </li>
                        @endforeach
                        </li>
                    </ul>
                </div>
                <div :class="{ '!block': activeTab === 2 }" x-show.transition.in.opacity.duration.600="activeTab === 2" class="hidden">
                    <ul class="border-b border-gray-300">
                        <li>
                            @foreach ($applying_products as $product)
                        <li>
                            <x-mypage-item-list>
                                <x-slot:image_url>{{ $product -> productImages[0] -> image_url }}</x-slot:image_url>
                                <x-slot:title>{{ $product -> title }}</x-slot:title>
                                <x-slot:point>{{ empty( $product -> point ) ? 'ポイント未設定' : $product->point .' pt'}}</x-slot:point>
                                <x-slot:likes>{{ count($product -> productLikes) }}</x-slot:likes>
                                <x-slot:tag>
                                    @foreach ($product->productTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                                <x-slot:button>
                                    <x-mypage-button-detail href="{{ route('items.show', ['item' =>  $product -> id]) }}"></x-mypage-button-detail>
                                    <x-mypage-button-edit href="{{ route('items.edit', ['item' =>  $product -> id]) }}"></x-mypage-button-edit>
                                    <x-mypage-button-delete action="{{ route('items.destroy', ['item' =>  $product -> id]) }}">
                                        <x-slot name="modal_title">
                                            {{ $product -> title }}を削除しますか？
                                        </x-slot>
                                        <x-slot name="modal_description">
                                            対象のアイテムを削除します。一度削除すると復元できません。
                                        </x-slot>
                                    </x-mypage-button-delete>
                                </x-slot:button>
                            </x-mypage-item-list>
                        </li>
                        @endforeach
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-mypage-app>
