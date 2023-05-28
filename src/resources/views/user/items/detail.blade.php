<?php


use Illuminate\Support\Facades\Auth;

//userのログイン情報を$user_infoに格納
$user_info = Auth::user();

// 貸出中か配送中の時は画像にタグをつける
if ($product->status == 3 || $product->status == 4) {
    $cannot_borrow_tag = false;
} else {
    $cannot_borrow_tag = true;
}
$unavailable_tag = $cannot_borrow_tag ? '' : '<span class="absolute left-0 top-0 rounded-br-lg bg-red-500 px-3 py-1.5 text-sm uppercase tracking-wider text-white">貸出中</span>';

//アイテムの画像の合計枚数を取得
$images_count = count($product->productImages);
?>

<x-user-app>
    <x-slot name="header_slot">
        <x-user-header textColor="text-blue-400" bgColor="bg-blue-400">
            <x-slot:app_name>Peer Product Share</x-slot:app_name>
            <x-slot:button_text>アイテム登録</x-slot:button_text>
            <x-slot:button_link>{{ route('items.create') }}</x-slot:button_link>
            <x-slot:earned_point>{{ Auth::user()->earned_point }}</x-slot:earned_point>
            <x-slot:distribution_point>{{ Auth::user()->distribution_point }}</x-slot:distribution_point>
            <x-slot:top_title_link>{{ route('items.index') }}</x-slot:top_title_link>
        </x-user-header>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-side-navi>
            <div class="pb-4">
                <nav class="flex mx-auto max-w-screen-5xl px-4 md:px-8" aria-label="Breadcrumb">
                    <ol class="my-4 inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center px-1 rounded hover:bg-gray-200">
                            <a href="{{ route('items.index') }}" class="inline-flex items-center text-lg text-gray-700 hover:text-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                一覧
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-lg text-gray-500 md:ml-2">{{$product->title}}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="mx-auto max-w-screen-5xl px-4 md:px-8">
                    <div class="">
                        <div class="grid gap-8 grid-cols-2 bg-white rounded-md shadow px-1">
                            <!-- images - start -->
                            <div class="md:py-8">
                                <div class="flex gap-2 h-full" x-data="{ activeImage: 0 }">
                                    <div class="w-1/4 grid h-full">
                                        <ul class="flex flex-col gap-1">
                                            @foreach($product->productImages as $product_image)
                                            <li class="w-full aspect-square bg-white border border-gray-300 flex-center max-w-full max-h-full">
                                                <img src="{{asset('images/'.$product_image->image_url)}}" class="w-full object-contain max-w-full max-h-full">
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="w-3/4 mb-4">
                                        <ul class="flex-center gap-2 h-full my-auto">
                                            @if($images_count !== 1)
                                            <li class="my-auto w-1/12 flex-center">
                                                <div @click="activeImage = activeImage + {{$images_count}}-1" class="rounded-full overflow-hidden bg-gray-200 p-1 cursor-pointer flex jusitify-center items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                                    </svg>
                                                </div>
                                            </li>
                                            @endif
                                            @foreach($product->productImages as $index => $product_image)
                                            <li :class="{ 'w-10/12 relative aspect-square bg-white max-w-full max-h-full flex-center': activeImage % {{$images_count}} === {{$index}}, 'hidden': activeImage % {{$images_count}} !== {{$index}}}" x-show.transition.in.opacity.duration.600=" activeImage % {{$images_count}} === {{$index}}">
                                                <img class="max-h-full my-auto object-contain w-full" src="{{asset('images/'.$product_image->image_url)}}" alt="アイテム写真">
                                                {!! $unavailable_tag !!}
                                            </li>
                                            @endforeach
                                            @if($images_count !== 1)
                                            <li class="my-auto w-1/12 flex-center">
                                                <div @click="activeImage = activeImage + 1" class="rounded-full overflow-hidden bg-gray-200 p-1 cursor-pointer flex jusitify-center items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                    </svg>
                                                </div>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- images - end -->

                            <!-- content - start -->
                            <div class="md:py-8">
                                <h1 class="text-3xl text-gray-800 font-bold mb-1 pl-2 border-l-4 border-blue-400">{{$product->title}}</h1>
                                <div class="px-2 flex mt-4 justify-between">
                                    <p class="title-font font-medium text-2xl text-gray-500">{{$product->point.'pt' ?? '未設定'}}</p>
                                    <span class="flex items-center likes" data-item_id="{{ $product->id }}" data-is_liked="{{ $product->isLiked }}">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="@if($product->isLiked) red @else none @endif" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                        </button>
                                        <span class="text-gray-600 ml-3 like-count">{{$product->product_likes_count}}</span>
                                    </span>
                                </div>
                                <!-- ここから -->
                                <div x-data="{ modelOpen: false }">
                                    @if ($login_user_can_borrow_this_product)
                                    <div @click="modelOpen =!modelOpen">
                                        <x-user-register-button textColor="text-blue-400" bgColor="bg-white" borderColor="border-blue-400">
                                            <x-slot name="button">借りる</x-slot>
                                        </x-user-register-button>
                                    </div>
                                    @else
                                    <div class="block cursor-pointer w-full rounded-lg my-1 py-3 font-bold text-center text-sm transition-all align-middle text-white bg-gray-300">
                                        借りる
                                    </div>
                                    @endif
                                    <!-- モーダル中身 -->
                                    <div x-cloak x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                            <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                            <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-40 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                                <div class="flex items-center justify-between space-x-4">
                                                    <h1 class="text-xl font-semibold text-gray-800 pl-2 border-l-4 border-blue-400">アイテムのレンタル</h1>
                                                    <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <p class="mt-2 text-gray-500 ">
                                                    次のアイテムをレンタルしますか
                                                </p>
                                                <form action="{{ route('items.borrow',['item'=>$product->id]) }}" method="POST" class="mt-5">
                                                    @csrf
                                                    <div>
                                                        <div class="mx-2 flex mt-4 justify-around py-4 border-y border-gray-200">
                                                            <p class="text-xl text-gray-800 font-bold">{{$product->title}}</p>
                                                            <p class="font-medium text-xl text-gray-500">{{$product->point}} pt</p>
                                                        </div>
                                                        <p class="text-gray-500 text-sm mt-4">
                                                            アイテムのオーナーにslackでメッセージが送信されます
                                                        </p>
                                                    </div>
                                                    <div class="mt-6">
                                                        @if ( $product->point > $user_info->distribution_point)
                                                        <div>
                                                            <div class="block w-full rounded-lg my-1 py-3 font-bold text-center text-sm transition-all align-middle text-red-400">
                                                                Peer Pointが不足しています
                                                            </div>
                                                        </div>
                                                        @else
                                                        <x-user-register-button textColor="text-white" bgColor="bg-blue-400" borderColor="border-blue-400">
                                                            <x-slot name="button">借りる</x-slot>
                                                        </x-user-register-button>
                                                        @endif
                                                        <div @click="modelOpen = false">
                                                            <div class="block cursor-pointer w-full rounded-lg my-1 py-3 font-bold text-center text-sm transition-all align-middle text-blue-400 hover:bg-blue-50">
                                                                キャンセル
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ここまで -->
                                <h3 class="text-xl mb-1 pb-1 border-b">アイテムの説明
                                </h3>
                                <p class="mb-4 text-base text-gray-500">
                                    {!! $product->description !!}
                                </p>
                                <h3 class="text-xl mb-1 pb-1 border-b">アイテムの状態
                                </h3>
                                <p class="mb-4 text-base text-gray-500">傷なし</p>
                                <h3 class="text-xl mb-1 pb-1 border-b">カテゴリ</h3>
                                <div class="mb-4">
                                    @foreach($product->productTags as $product_tag)
                                    <span class="inline-flex items-center gap-1 rounded-full border border-gray-300 bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-400">
                                        {{$product_tag->tag->name}}
                                    </span>
                                    @endforeach
                                </div>
                                <h3 class="text-xl mb-1 pb-1 border-b">出品者</h3>

                                <a href="{{ route('users.profile',['user_id'=>$product->user->id]) }}" class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <div class="sm:pb-4">
                                        <div class="flex items-center space-x-4 rounded hover:bg-gray-200">
                                            <div class="flex-shrink-0 pl-1">
                                                <img class="w-8 h-8 rounded-full" src="{{ $product->user->icon }}" alt="Neil image">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{$product->user->display_name}}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    {{$product->user->email}}
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <!-- content - end -->
                        </div>
                    </div>
                </div>
            </div>
        </x-user-side-navi>
    </x-slot>
</x-user-app>
