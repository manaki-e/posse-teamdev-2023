<x-mypage-app>
    <x-slot:border_color>border-peer-request</x-slot:border_color>
    <x-slot:title>いいねしたリクエスト一覧</x-slot:title>
    <x-slot:earned_point>580</x-slot:earned_point>
    <x-slot:distribution_point>5000</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <div>
            <div>
                <ul class="border-b border-gray-300">
                    @foreach ($liked_requests as $request)
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
                            @if ($request -> user_id === $user -> id)
                            <x-slot:button>
                                <p class="text-red-500">これは自分が投稿したリクエストです。</p>
                            </x-slot:button>
                            @elseif ($request -> completed_at)
                            <x-slot:button>
                                <p class="text-red-500">これはすでに解決されたリクエストです。</p>
                            </x-slot:button>
                            @else
                            <x-slot:button>
                                <a href="{{ $request -> type_id == $product_request_type_id ? route('items.create-with-request', $request -> id) : route('events.create-with-request', $request ->id) }}" class="flex select-none items-center gap-3 rounded-lg bg-peer-request py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-yellow-500/20 transition-all hover:shadow-lg hover:shadow-yellow-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" data-ripple-light="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    リクエストに応える
                                </a>
                            </x-slot:button>
                            @endif
                        </x-mypage-request-list>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-mypage-app>
