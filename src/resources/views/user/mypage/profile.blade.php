<x-mypage-app>
    <x-slot:border_color>admin-border-green</x-slot:border_color>
    <x-slot:title>プロフィール</x-slot:title>
    <x-slot:earned_point>{{ Auth::user()->earned_point }}</x-slot:earned_point>
    <x-slot:distribution_point>{{ Auth::user()->distribution_point }}</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full font-sans">
        <div class="flex text-gray-600 mb-4">
            <div class="w-1/6">
                <div class="w-full rounded-full overflow-hidden border-2 border-gray-900">
                    <img src="{{ Auth::user()->icon }}" alt="" class="object-cover">
                </div>
            </div>
            <div class="w-5/6 pl-6">
                <h2 class="font-bold text-xl text-gray-800 mb-2">{{ Auth::user()->name }}</h2>
                <div class="pl-2 flex gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                        </path>
                    </svg>
                    <p class="text-sm">{{ Auth::user()->display_name }}</p>
                </div>
                <div class="pl-2 flex gap-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 20C3.45 20 2.979 19.804 2.587 19.412C2.195 19.02 1.99934 18.5493 2 18V6C2 5.45 2.196 4.979 2.588 4.587C2.98 4.195 3.45067 3.99934 4 4H20C20.55 4 21.021 4.196 21.413 4.588C21.805 4.98 22.0007 5.45067 22 6V18C22 18.55 21.804 19.021 21.412 19.413C21.02 19.805 20.5493 20.0007 20 20H4ZM12 13L4 8V18H20V8L12 13ZM12 11L20 6H4L12 11ZM4 8V6V18V8Z" fill="currentColor" />
                    </svg>
                    <p class="text-sm">{{ Auth::user()->email }}</p>
                </div>
                <div class="pl-2 flex gap-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_654_5439)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.001 6.00084C15.0012 6.62146 14.8089 7.22687 14.4508 7.73369C14.0926 8.24052 13.5861 8.62383 13.001 8.83084V11.0008H16.001C16.7967 11.0008 17.5597 11.3169 18.1223 11.8795C18.6849 12.4421 19.001 13.2052 19.001 14.0008V15.1708C19.6685 15.4067 20.2311 15.871 20.5894 16.4816C20.9476 17.0923 21.0785 17.8099 20.9588 18.5076C20.8391 19.2054 20.4766 19.8384 19.9354 20.2947C19.3941 20.751 18.709 21.0013 18.001 21.0013C17.2931 21.0013 16.6079 20.751 16.0666 20.2947C15.5254 19.8384 15.1629 19.2054 15.0432 18.5076C14.9235 17.8099 15.0544 17.0923 15.4126 16.4816C15.7709 15.871 16.3335 15.4067 17.001 15.1708V14.0008C17.001 13.7356 16.8957 13.4813 16.7081 13.2937C16.5206 13.1062 16.2662 13.0008 16.001 13.0008H8.00101C7.73579 13.0008 7.48144 13.1062 7.2939 13.2937C7.10636 13.4813 7.00101 13.7356 7.00101 14.0008V15.1708C7.6685 15.4067 8.2311 15.871 8.58937 16.4816C8.94763 17.0923 9.07849 17.8099 8.95882 18.5076C8.83914 19.2054 8.47664 19.8384 7.93538 20.2947C7.39412 20.751 6.70896 21.0013 6.00101 21.0013C5.29305 21.0013 4.60789 20.751 4.06663 20.2947C3.52538 19.8384 3.16287 19.2054 3.0432 18.5076C2.92352 17.8099 3.05438 17.0923 3.41265 16.4816C3.77091 15.871 4.33351 15.4067 5.00101 15.1708V14.0008C5.00101 13.2052 5.31708 12.4421 5.87969 11.8795C6.4423 11.3169 7.20536 11.0008 8.00101 11.0008H11.001V8.83084C10.4822 8.64768 10.0236 8.32539 9.67561 7.89921C9.32758 7.47303 9.10341 6.95937 9.02761 6.41438C8.95182 5.8694 9.02732 5.31406 9.24586 4.80909C9.46439 4.30412 9.81756 3.86894 10.2667 3.55115C10.7159 3.23335 11.2438 3.04517 11.7927 3.00717C12.3417 2.96916 12.8905 3.08281 13.3791 3.33567C13.8678 3.58854 14.2776 3.97089 14.5636 4.44093C14.8497 4.91098 15.001 5.45061 15.001 6.00084ZM12.001 5.00084C11.7358 5.00084 11.4814 5.1062 11.2939 5.29374C11.1064 5.48127 11.001 5.73563 11.001 6.00084C11.001 6.26606 11.1064 6.52041 11.2939 6.70795C11.4814 6.89549 11.7358 7.00084 12.001 7.00084C12.2662 7.00084 12.5206 6.89549 12.7081 6.70795C12.8956 6.52041 13.001 6.26606 13.001 6.00084C13.001 5.73563 12.8956 5.48127 12.7081 5.29374C12.5206 5.1062 12.2662 5.00084 12.001 5.00084ZM6.00101 17.0008C5.73579 17.0008 5.48144 17.1062 5.2939 17.2937C5.10636 17.4813 5.00101 17.7356 5.00101 18.0008C5.00101 18.2661 5.10636 18.5204 5.2939 18.7079C5.48144 18.8955 5.73579 19.0008 6.00101 19.0008C6.26622 19.0008 6.52058 18.8955 6.70811 18.7079C6.89565 18.5204 7.00101 18.2661 7.00101 18.0008C7.00101 17.7356 6.89565 17.4813 6.70811 17.2937C6.52058 17.1062 6.26622 17.0008 6.00101 17.0008ZM18.001 17.0008C17.7358 17.0008 17.4814 17.1062 17.2939 17.2937C17.1064 17.4813 17.001 17.7356 17.001 18.0008C17.001 18.2661 17.1064 18.5204 17.2939 18.7079C17.4814 18.8955 17.7358 19.0008 18.001 19.0008C18.2662 19.0008 18.5206 18.8955 18.7081 18.7079C18.8957 18.5204 19.001 18.2661 19.001 18.0008C19.001 17.7356 18.8957 17.4813 18.7081 17.2937C18.5206 17.1062 18.2662 17.0008 18.001 17.0008Z" fill="currentColor" />
                        </g>
                        <defs>
                            <clipPath id="clip0_654_5439">
                                <rect width="24" height="24" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <p class="text-sm">{{ $user->department->name }}</p>
                </div>
            </div>
        </div>
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-peer-perk hover:text-peer-perk" :class="{'relative text-peer-perk after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-peer-perk': activeTab === 0}">
                            アイテム
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-peer-perk hover:text-peer-perk" :class="{'relative text-peer-perk after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-peer-perk': activeTab === 1}">
                            イベント
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 2" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-peer-perk hover:text-peer-perk" :class="{'relative text-peer-perk after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-peer-perk': activeTab === 2}">
                            リクエスト
                        </a>
                    </li>
                </ul>
            </div>
            <!-- アイテム -->
            <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                <div class="overflow-hidden border-t border-gray-200 mb-4">
                    <section class="text-gray-600 body-font mx-auto max-w-5xl">
                        <div class="py-12 mx-auto">
                            <div class="grid grid-cols-4 justify-items-stretch gap-8 mb-8">
                                @foreach ($products as $product)
                                <div data-status="{{ $product->status }}" data-tag="{{ $product->data_tag  }}" class="col-span-1 filter-target shadow-md bg-white rounded-lg flex flex-col justify-between">
                                    <a href="/items/{{$product->id}}">
                                        <div class="bg-white relative h-48 rounded-t-lg overflow-hidden">
                                            <img alt="ecommerce" class="object-cover w-full h-full block" src=" {{asset('images/'.$product->productImages->first()->image_url)}}">
                                            @if ( $product->japanese_status !== '貸出可能' )
                                            <span class="absolute left-0 top-0 rounded-br-lg bg-red-500 px-3 py-1.5 text-sm uppercase tracking-wider text-white">
                                                貸出中
                                            </span>
                                            @endif
                                        </div>
                                        <div class="p-4 pb-0">
                                            <h2 class="text-gray-900 title-font text-lg font-medium">{{$product->title}}</h2>
                                            <p class="text-gray-500 text-xs tracking-widest title-font mb-1">
                                                {!! $product->description !!}
                                            </p>
                                        </div>
                                    </a>
                                    <div class="p-4 flex justify-between">
                                        <p class="mt-1">{{$product->point}} pt</p>
                                        <div class="flex relative likes" data-item_id="{{ $product->id }}" data-is_liked="{{ $product->isLiked }}">
                                            <button class="mt-1 text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="@if($product->isLiked) red @else none @endif" viewBox="0 0 24 24" stroke-width="1.5" stroke="@if($product->isLiked) red @else currentColor @endif" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                </svg>
                                            </button>
                                            <div class="mt-3">
                                                <p class="text-xs like-count">{{$product->product_likes_count}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                    </section>
                </div>
            </div>
            <!-- イベント -->
            <div x-cloak :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                <div class="overflow-hidden border-t border-gray-200 mb-4">
                    <div class="mx-auto max-w-5xl my-4">
                        <div class="mx-auto grid grid-cols-2 justify-items-stretch gap-4">
                            @foreach($events as $event)
                            <div data-completed="{{ $event->isCompleted }}" data-tag="{{ $event->data_tag  }}" class="h-full col-span-1 filter-target">
                                <div class="h-full rounded-lg border border-gray-200 bg-white shadow-sm">
                                    <div class="h-full flex flex-col justify-between rounded-lg text-xs px-4 pt-4 text-gray-500 bg-white">
                                        <section>
                                            <!-- イベント名 -->
                                            <div class="w-full text-xl text-gray-800 mb-4">
                                                <p class="font-bold pl-2 border-l-4 border-pink-600">{{ $event->title }}</p>
                                            </div>
                                            <!-- 概要 -->
                                            <div class="w-full text-sm text-gray-800 mb-4">
                                                <p class="text-gray-500">{!! $event->description !!}</p>
                                            </div>
                                            <!-- データ -->
                                            <div class="relative flex mb-4">
                                                <div class="w-1/2 space-y-1 flex flex-col text-sm">
                                                    <h3 class="pl-1 mb-1 border-l-2 border-pink-600 text-gray-800">詳細</h3>
                                                    <p class="pl-1">開始日時：{{ $event  -> start_date ? date( 'Y.m.d H:i', strtotime( $event  -> start_date ) ) : '未定' }}</p>
                                                    <p class="pl-1">終了日時：{{ $event  -> end_date ? date( 'Y.m.d H:i', strtotime( $event  -> end_date ) ) : '未定' }}</p>
                                                    <p class="pl-1">形態：{{ $event->location }}</p>
                                                    <p class="pl-1">主催：
                                                        <!-- プロフィール参照機能できたら代入 -->
                                                        <span><a href="{{ route('users.profile',['user_id'=>$event->user->id]) }}" class="hover:border-gray-400 border-transparent border-b">{{ $event->user->display_name }}</a></span>
                                                    </p>
                                                </div>
                                                <!-- ユーザーアイコン -->
                                                <div class="w-1/2 pr-2 flex items-end justify-end -space-x-1">
                                                    @foreach ($event->eventParticipants as $event_participant)
                                                    <div x-data="{ tooltip: false }" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" class="h-8 w-8 relative z-30">
                                                        <img class="h-full w-full rounded-full object-cover object-center ring ring-white" src="{{ $event_participant->user->icon }}" alt="icon" />
                                                        <div x-cloak x-show.transition.origin.top="tooltip" class="absolute w-20">{{ $event_participant->user->display_name }}</div>
                                                    </div>
                                                    @endforeach
                                                    <div x-data="{ openTooltip: false }" x-on:mouseover="openTooltip = true" x-on:mouseleave="openTooltip = false" class="z-50 relative">
                                                        @if (empty(count($event->eventParticipants)))
                                                        予約者なし
                                                        @elseif (count($event->eventParticipants) >= 5)
                                                        <div class="flex bg-gray-200 h-8 w-8 items-center justify-center overflow-hidden rounded-full ring ring-white">
                                                            <button id="" class="h-full w-full inline-flex items-center justify-center rounded-full text-gray-700 shadow-sm align-middle">
                                                                <span class="leading-none">
                                                                    •••
                                                                </span>
                                                            </button>
                                                            <div x-cloak x-show.transition.origin.top="openTooltip" class="absolute rounded bg-black opacity-75 text-white p-1 gap-1 w-20 bottom-0 left-full">
                                                                @foreach ($event->eventParticipants as $event_participant)
                                                                <p>{{ $event_participant->user->display_name }}</p>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <!-- ボタン・タグ -->
                                        <div>
                                            <!-- タグ -->
                                            <div class="w-full">
                                                <div class="inline-flex flex-wrap gap-1 mb-4">
                                                    @foreach($event->eventTags as $event_tag)
                                                    <span class="items-center rounded-full border border-gray-300 bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-400">
                                                        {{ $event_tag->tag->name }}
                                                    </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!-- ボタン・モーダル -->
                                            <div x-data="{ modelOpen: false }">
                                                <div class="flex items-center justify-center">
                                                    @if($event->isCompleted == "開催済み")
                                                    <div class="block  w-full rounded-lg my-3 py-3 font-bold text-center text-sm align-middle text-white bg-gray-300">
                                                        開催済み
                                                    </div>
                                                    @elseif($event->user->id === Auth::user()->id)
                                                    <div class="block  w-full rounded-lg my-3 py-3 font-bold text-center text-sm align-middle text-white bg-pink-800">
                                                        自分が主催するイベントです
                                                    </div>
                                                    @elseif($event->isParticipated)
                                                    <div class="block  w-full rounded-lg my-3 py-3 font-bold text-center text-sm align-middle text-white bg-pink-800">
                                                        予約済み
                                                    </div>
                                                    @else
                                                    <div @click="modelOpen =!modelOpen" class="w-full">
                                                        <x-user-register-button textColor="text-pink-600" bgColor="bg-white" borderColor="border-pink-600">
                                                            <x-slot name="button">予約する</x-slot>
                                                        </x-user-register-button>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                                        <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                                        <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-40 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                                            <div class="flex items-center justify-between space-x-4">
                                                                <h1 class="text-xl font-semibold text-gray-800 pl-2 border-l-4 border-pink-600">参加予約</h1>
                                                                <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <p class="mt-2 text-sm text-gray-500 ">
                                                                主催者に支払うポイントを設定してください
                                                            </p>
                                                            <form class="mt-5" method="POST" action="{{ route('events.participate',$event->id) }}">
                                                                @csrf
                                                                <div>
                                                                    <label class="block text-sm text-gray-700 capitalize dark:text-gray-200">参加ポイント</label>
                                                                    <input name="point" type="number" step="10" min="0" max="500" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md" required />
                                                                    <p class="ml-2 text-xs text-gray-500 ">
                                                                        ポイントの上限は 500 pt
                                                                    </p>
                                                                </div>
                                                                <div class="mt-6">
                                                                    <x-user-register-button textColor="text-white" bgColor="bg-pink-600" borderColor="border-pink-600">
                                                                        <x-slot name="button">予約する</x-slot>
                                                                    </x-user-register-button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-full flex items-end justify-between mb-2">
                                                <p>{{$event->created_at->format('Y.m.d')}}</p>
                                                <div class="likes" data-event_id="{{ $event->id }}" data-is_liked="{{ $event->isLiked }}">
                                                    <div class="flex justify-end">
                                                        <button class="text-gray-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="@if($event->isLiked) red @else none @endif" viewBox="0 0 24 24" stroke-width="1.5" stroke="@if($event->isLiked) red @else currentColor @endif" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                            </svg>
                                                        </button>
                                                        <div class="mt-3">
                                                            <p class="text-xs like-count">{{ $event->event_likes_count }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- リクエスト -->
            <div x-cloak :class="{ '!block': activeTab === 2 }" x-show.transition.in.opacity.duration.600="activeTab === 2" class="hidden">
                <div class="overflow-hidden border-t border-gray-200 mb-4">
                    <div class="mx-auto max-w-5xl my-4">
                        <div class="mx-auto grid grid-cols-2 items-stretch gap-4">
                            @foreach ($requests as $request)
                            <div class="col-span-1 filter-target" data-tag="{{ $request->data_tag }}">
                                <div class="h-full rounded-lg border border-gray-200 bg-white shadow-sm">
                                    <div class="flex flex-col justify-between rounded-lg h-full text-xs shadow-md p-4 pb-1 text-gray-500 bg-white">
                                        <div>
                                            <!-- イベント名 -->
                                            <div class="w-full text-xl text-gray-800 mb-4">
                                                <p class="font-bold pl-2 border-l-4 border-peer-request">{{$request->title}}</p>
                                            </div>
                                            <!-- 概要 -->
                                            <div class="w-full mb-2 text-sm text-gray-800">
                                                <p class="text-gray-500 break-words">
                                                    {!! $request->description !!}
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <!--ユーザー ・ タグ -->
                                            <div class="flex justify-between">
                                                <div class="flex flex-wrap gap-1 items-center">
                                                    @foreach($request->requestTags as $tag)
                                                    <span class="items-center gap-1 rounded-full border border-gray-300 bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-400">
                                                        {{ $tag->tag->name }}
                                                    </span>
                                                    @endforeach
                                                </div>
                                                <a href="{{ route('users.profile',['user_id'=>$request->user->id]) }}" class="divide-y divide-gray-200 flex justify-end">
                                                    <div class="flex justify-end space-x-4 p-1 rounded-md hover:bg-gray-50">
                                                        <div class="pl-1">
                                                            <img class="w-8 h-8 rounded-full" src="{{ $request->user->icon }}" alt="icon">
                                                        </div>
                                                        <div class="min-w-0 flex items-center">
                                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                                {{ $request->user->display_name }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- ボタン・モーダル -->
                                            <div x-data="{ modelOpen: false }">
                                                @if($request->user_id===Auth::user()->id)
                                                <div class="block  w-full rounded-lg my-3 py-3 font-bold text-center text-sm align-middle text-white bg-gray-300">
                                                    自分のリクエストです
                                                </div>
                                                @else
                                                <div @click="modelOpen =!modelOpen" class="flex items-center justify-center px-3">
                                                    <x-user-register-button textColor="text-peer-request" bgColor="bg-white" borderColor="border-peer-request">
                                                        <x-slot name="button">リクエストに応える</x-slot>
                                                    </x-user-register-button>
                                                </div>
                                                @endif

                                                <div x-cloak x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                                        <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                                        <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-40 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                                            <div class="flex items-center justify-between space-x-4">
                                                                <h1 class="text-xl font-semibold text-gray-800 pl-2 border-l-4 border-peer-request">
                                                                    リクエストに応える</h1>
                                                                <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="mt-5">
                                                                <p class="block text-sm mb-4 text-gray-700">次のアプリに移動します</p>
                                                                <div class="flex justify-center items-center">
                                                                    <div class="flex items-center {{ $app[$request->type_id]['color'] }}">
                                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="stroke-current">
                                                                            <path d="M3 12C3 13.1819 3.23279 14.3522 3.68508 15.4442C4.13738 16.5361 4.80031 17.5282 5.63604 18.364C6.47177 19.1997 7.46392 19.8626 8.55585 20.3149C9.64778 20.7672 10.8181 21 12 21C13.1819 21 14.3522 20.7672 15.4442 20.3149C16.5361 19.8626 17.5282 19.1997 18.364 18.364C19.1997 17.5282 19.8626 16.5361 20.3149 15.4442C20.7672 14.3522 21 13.1819 21 12C21 10.8181 20.7672 9.64778 20.3149 8.55585C19.8626 7.46392 19.1997 6.47177 18.364 5.63604C17.5282 4.80031 16.5361 4.13738 15.4442 3.68508C14.3522 3.23279 13.1819 3 12 3C10.8181 3 9.64778 3.23279 8.55585 3.68508C7.46392 4.13738 6.47177 4.80031 5.63604 5.63604C4.80031 6.47177 4.13738 7.46392 3.68508 8.55585C3.23279 9.64778 3 10.8181 3 12Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                            <path d="M10 16V8H12.5C13.163 8 13.7989 8.26339 14.2678 8.73223C14.7366 9.20107 15 9.83696 15 10.5C15 11.163 14.7366 11.7989 14.2678 12.2678C13.7989 12.7366 13.163 13 12.5 13H10" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                        </svg>
                                                                        <span class="ml-3 font-medium text-xl font-patua">
                                                                            {{ $app[$request->type_id]['name'] }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-6">
                                                                    <a @if($request->type_id===$product_request_type_id)
                                                                        href="{{ route('items.create-with-request',$request->id) }}"
                                                                        @else
                                                                        href="{{ route('events.create-with-request',$request->id) }}"
                                                                        @endif>
                                                                        <x-user-register-button textColor="text-white" bgColor="bg-peer-request" borderColor="border-peer-request">
                                                                            <x-slot name="button">
                                                                                次へ
                                                                            </x-slot>
                                                                        </x-user-register-button>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 日付・いいね -->
                                            <div class="flex items-end justify-between mb-1">
                                                <p>{{$request->created_at->format('Y.m.d')}}</p>
                                                <div class="likes" data-request_id="{{ $request->id }}" data-is_liked="{{ $request->isLiked }}">
                                                    <div class="flex relative">
                                                        <button class="text-gray-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="@if($request->isLiked) red @else none @endif" viewBox="0 0 24 24" stroke-width="1.5" stroke="@if($request->isLiked) red @else currentColor @endif" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                            </svg>
                                                        </button>
                                                        <div class="mt-3">
                                                            <p class="text-xs like-count">{{ $request->request_likes_count }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-mypage-app>
