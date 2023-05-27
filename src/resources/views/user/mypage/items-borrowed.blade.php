<x-mypage-app>
    <x-slot:border_color>border-blue-400</x-slot:border_color>
    <x-slot:title>借りているアイテム一覧</x-slot:title>
    <x-slot:earned_point>580</x-slot:earned_point>
    <x-slot:distribution_point>5000</x-slot:distribution_point>

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
                        <x-slot:button></x-slot:button>
                    </x-mypage-item-list>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</x-mypage-app>
