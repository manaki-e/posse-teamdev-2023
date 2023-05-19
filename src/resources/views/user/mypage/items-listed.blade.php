<x-mypage-app>
    <x-slot:title>出品したアイテム一覧</x-slot:title>
    <x-slot:earned_point>580</x-slot:earned_point>
    <x-slot:distribution_point>5000</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 0}">
                            出品中
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 1}">
                            貸出中
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 2" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 2}">
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
                            <x-mypage-list>
                                <x-slot:image_url>{{ $product -> productImages[0] -> image_url }}</x-slot:image_url>
                                <x-slot:title>{{ $product -> title }}</x-slot:title>
                                <x-slot:point>{{ empty( $product -> point ) ? '未設定' : $product->point .' pt'}}</x-slot:point>
                                <x-slot:likes>{{ count($product -> productLikes) }}</x-slot:likes>
                                <x-slot:tag>
                                    @foreach ($product->productTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                            </x-mypage-list>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                    <ul class="border-b border-gray-300">
                        <li>
                            @foreach ($borrowed_products as $product)
                        <li>
                            <x-mypage-list>
                                <x-slot:image_url>{{ $product -> productImages[0] -> image_url }}</x-slot:image_url>
                                <x-slot:title>{{ $product -> title }}</x-slot:title>
                                <x-slot:point>{{ empty( $product -> point ) ? '未設定' : $product->point .' pt'}}</x-slot:point>
                                <x-slot:likes>{{ count($product -> productLikes) }}</x-slot:likes>
                                <x-slot:tag>
                                    @foreach ($product->productTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                            </x-mypage-list>
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
                            <x-mypage-list>
                                <x-slot:image_url>{{ $product -> productImages[0] -> image_url }}</x-slot:image_url>
                                <x-slot:title>{{ $product -> title }}</x-slot:title>
                                <x-slot:point>{{ empty( $product -> point ) ? 'ポイント未設定' : $product->point .' pt'}}</x-slot:point>
                                <x-slot:likes>{{ count($product -> productLikes) }}</x-slot:likes>
                                <x-slot:tag>
                                    @foreach ($product->productTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                            </x-mypage-list>
                        </li>
                        @endforeach
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-mypage-app>
