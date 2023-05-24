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
                            <x-slot:title>{{ $request  -> title }}</x-slot:title>
                            <x-slot:description>{{ $request  -> description }}</x-slot:description>
                            <x-slot:tag>
                                @foreach ($request ->requestTags as $tag)
                                <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                @endforeach
                            </x-slot:tag>
                            <x-slot:date>{{ date( 'Y.m.d', strtotime( $request  -> created_at ) ) }}</x-slot:date>
                            <x-slot:likes>{{ count($request  -> requestLikes) }}</x-slot:likes>
                            <x-slot:user_icon>{{ $request  -> user -> icon }}</x-slot:user_icon>
                            <x-slot:user_name>{{ $request  -> user -> name }}</x-slot:user_name>
                            <x-slot:button></x-slot:button>
                        </x-mypage-request-list>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-mypage-app>
