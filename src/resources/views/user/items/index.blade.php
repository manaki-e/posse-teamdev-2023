<x-user-app>
    <x-slot name="header_slot">
        <x-user-header textColor="text-blue-400" bgColor="bg-blue-400">
            <x-slot:app_name>Peer Product Share</x-slot:app_name>
            <x-slot:button_text>アイテム登録</x-slot:button_text>
            <x-slot:earned_point>580</x-slot:earned_point>
            <x-slot:distribution_point>5000</x-slot:distribution_point>
        </x-user-header>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-side-navi>
            <div class="mx-auto max-w-5xl">
                <x-user-search-box bgColor="bg-blue-400">
                    <x-user-search-tags>
                        <x-slot name="category1">利用状況</x-slot>
                        <x-slot name="available">利用可能</x-slot>
                        <x-slot name="unavailable">利用不可</x-slot>
                        <x-slot name="category_tags">
                            @foreach($product_tags as $key=>$value)
                            <div class="w-auto mx-1 border rounded border-gray-200">
                                <div class="flex items-center px-3">
                                    <input id="{{$value->id}}" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                    <label for="{{$value->id}}" class="w-full py-3 pl-1 text-sm font-medium text-gray-900">{{ $value->name }}</label>
                                </div>
                            </div>
                            @endforeach
                        </x-slot>
                    </x-user-search-tags>
                </x-user-search-box>

                <section class="text-gray-600 body-font mx-auto max-w-5xl">
                    <div class="py-12 mx-auto">
                        <div class="grid grid-cols-4 gap-8 mb-8">
                            @foreach ($products as $product)
                            <div class="col-span-1">
                                <a href="/items/{{$product->id}}">
                                    <div class="shadow-md">
                                        <div class="bg-white relative h-48 rounded overflow-hidden">
                                            <img alt="ecommerce" class="object-cover object-center w-full h-full block" src=" {{asset('images/'.$product->productImages->first()->image_url)}}">
                                            @if ( $product->japanese_status !== '貸出可能' )
                                            <span class="absolute left-0 top-0 rounded-br-lg bg-red-500 px-3 py-1.5 text-sm uppercase tracking-wider text-white">
                                                貸出中
                                            </span>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h2 class="text-gray-900 title-font text-lg font-medium">{{$product->title}}</h2>
                                            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">
                                                {!! $product->description !!}
                                            </h3>
                                            <div class="flex justify-between">
                                                <p class="mt-1">{{$product->point}} pt</p>
                                                <div class="flex relative">
                                                    <button class="mt-1 text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                        </svg>
                                                    </button>
                                                    <div class="mt-3">
                                                        <p class="text-xs">{{$product->product_likes_count}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        {{ $productsPaginated->withPath(url('/items'))->links() }}
                </section>
            </div>

        </x-user-side-navi>

    </x-slot>
</x-user-app>
