<x-mypage-app>
    <x-slot:border_color>border-peer-request</x-slot:border_color>
    <x-slot:title>いいねしたリクエスト一覧</x-slot:title>
    <x-slot:earned_point>{{ Auth::user()->earned_point }}</x-slot:earned_point>
    <x-slot:distribution_point>{{ Auth::user()->distribution_point }}</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-peer-request hover:text-peer-request" :class="{'relative text-peer-request after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-peer-request': activeTab === 0}">
                            未解決
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-peer-request hover:text-peer-request" :class="{'relative text-peer-request after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-peer-request': activeTab === 1}">
                            解決済み
                        </a>
                    </li>
                </ul>
            </div>
            <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                <ul class="border-b border-gray-300">
                    @foreach ($unresolved_liked_requests as $request)
                    <li>
                        <x-mypage-request-list>
                            <x-slot:id>{{ $request->id }}</x-slot:id>
                            <x-slot:is_liked>{{ $request->idLiked }}</x-slot:is_liked>
                            <x-slot:fill>@if($request->isLiked) red @else none @endif</x-slot:fill>
                            <x-slot:title>{{ $request -> title }}</x-slot:title>
                            <x-slot:description>{{ $request -> description }}</x-slot:description>
                            <x-slot:tag>
                                @foreach ($request -> requestTags as $tag)
                                <x-user-tag>{{ $tag -> tag -> name }}</x-user-tag>
                                @endforeach
                            </x-slot:tag>
                            <x-slot:date>{{ date( 'Y.m.d', strtotime( $request -> created_at ) ) }}</x-slot:date>
                            <x-slot:likes>{{ $request -> request_likes_count }}</x-slot:likes>
                            <x-slot:user_icon>{{ $request -> user -> icon }}</x-slot:user_icon>
                            <x-slot:user_name>{{ $request -> user -> name }}</x-slot:user_name>
                            <x-slot:status></x-slot:status>
                            <x-slot:button>
                                <a href="{{ $request -> type_id == $product_request_type_id ? route('items.create-with-request', $request -> id) : route('events.create-with-request', $request ->id) }}" class="flex select-none items-center gap-3 rounded-lg bg-peer-request py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-sm shadow-yellow-500/20 transition-all hover:shadow-lg hover:shadow-yellow-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" data-ripple-light="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    リクエストに応える
                                </a>
                            </x-slot:button>
                        </x-mypage-request-list>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                <ul class="border-b border-gray-300">
                    @foreach ($resolved_liked_requests as $request)
                    <li>
                        <x-mypage-request-list>
                            <x-slot:title>{{ $request -> title }}</x-slot:title>
                            <x-slot:description>{{ $request -> description }}</x-slot:description>
                            <x-slot:tag>
                                @foreach ($request -> requestTags as $tag)
                                <x-user-tag>{{ $tag -> tag -> name }}</x-user-tag>
                                @endforeach
                            </x-slot:tag>
                            <x-slot:date>{{ date( 'Y.m.d', strtotime( $request -> created_at ) ) }}</x-slot:date>
                            <x-slot:likes>{{ $request -> request_likes_count }}</x-slot:likes>
                            <x-slot:user_icon>{{ $request -> user -> icon }}</x-slot:user_icon>
                            <x-slot:user_name>{{ $request -> user -> name }}</x-slot:user_name>
                            <x-slot:status>解決済み</x-slot:status>
                            <x-slot:button></x-slot:button>
                        </x-mypage-request-list>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-mypage-app>
