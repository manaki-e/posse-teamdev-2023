<x-mypage-app>
    <x-slot:border_color>border-blue-400</x-slot:border_color>
    <x-slot:title>借りているアイテム一覧</x-slot:title>
    <x-slot:earned_point>{{ Auth::user()->earned_point }}</x-slot:earned_point>
    <x-slot:distribution_point>{{ Auth::user()->distribution_point }}</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <ul class="border-b border-gray-300">
            @foreach ($borrowed_products as $product)
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
                        <x-slot:button>
                            <div class="whitespace-nowrap flex flex-col">
                                @if ($product -> status === \App\Models\Product::STATUS['delivering'])
                                <x-mypage-button-item-receive action="{{ route('items.receive', ['item' =>  $product -> id]) }}">
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
                                </x-mypage-button-item-receive>
                                <x-mypage-button-item-cancel action="{{ route('items.cancel', ['item' =>  $product -> id]) }}">
                                    <x-slot name="content">
                                        キャンセル
                                    </x-slot>
                                    <x-slot:logo_path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                    </x-slot:logo_path>
                                    <x-slot name="modal_title">
                                        アイテムの貸出をキャンセルする
                                    </x-slot>
                                    <x-slot name="modal_description">
                                        この操作はアイテムが配送される前に行ってください。貸出をキャンセルすると、アイテムの貸出がキャンセルされ、貸出可の状態になります。
                                    </x-slot>
                                    <x-slot name="method"></x-slot>
                                    <x-slot name="form_slot"></x-slot>
                                </x-mypage-button-item-cancel>
                                @endif
                            </div>
                        </x-slot:button>
                    </x-mypage-item-list>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</x-mypage-app>
