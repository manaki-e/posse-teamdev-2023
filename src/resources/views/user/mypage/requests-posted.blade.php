<x-mypage-app>
    <x-slot:border_color>border-peer-request</x-slot:border_color>
    <x-slot:title>投稿したリクエスト一覧</x-slot:title>
    <x-slot:earned_point>580</x-slot:earned_point>
    <x-slot:distribution_point>5000</x-slot:distribution_point>

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
                    <div class=""></div>
                </ul>
            </div>
            <div>
                <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                    <ul class="border-b border-gray-300">
                        @foreach ($unresolved_requests as $request)
                        <li>
                            <x-mypage-request-list>
                                <x-slot:title>{{ $request -> title }}</x-slot:title>
                                <x-slot:description>{{ $request -> description }}</x-slot:description>
                                <x-slot:tag>
                                    @foreach ($request->requestTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                                <x-slot:date>{{ date( 'Y.m.d', strtotime( $request  -> created_at ) ) }}</x-slot:date>
                                <x-slot:likes>{{ count($request -> requestLikes) }}</x-slot:likes>
                                <x-slot:user_icon>{{ $request  -> user -> icon }}</x-slot:user_icon>
                                <x-slot:user_name>{{ $request  -> user -> name }}</x-slot:user_name>
                                <x-slot:button>
                                    <x-mypage-button-request-resolve action="{{ route('requests.resolve', ['request' =>  $request -> id]) }}">
                                        <x-slot:content>リクエスト解決済み</x-slot:content>
                                        <x-slot:logo_path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
                                        </x-slot:logo_path>
                                        <x-slot:modal_title>投稿したリクエストを解決済みにする</x-slot:modal_title>
                                        <x-slot:modal_description>リクエストが解決されたら、解決済みにしてください。一度解決済みにすると、解除できません。</x-slot:modal_description>
                                        <x-slot:method></x-slot:method>
                                        <x-slot:form_slot></x-slot:form_slot>
                                    </x-mypage-button-request-resolve>
                                    <x-mypage-button-edit href="{{ route('requests.edit', ['request' =>  $request -> id]) }}"></x-mypage-button-edit>
                                    <x-mypage-button-delete action="{{ route('requests.destroy', ['request' =>  $request -> id]) }}">
                                        <x-slot name="modal_title">
                                            {{ $request -> title }}を削除しますか？
                                        </x-slot>
                                        <x-slot name="modal_description">
                                            対象のリクエストを削除します。一度削除すると復元できません。
                                        </x-slot>
                                    </x-mypage-button-delete>
                                </x-slot:button>
                            </x-mypage-request-list>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                    <ul class="border-b border-gray-300">
                        @foreach ($resolved_requests as $request)
                        <li>
                            <x-mypage-request-list>
                                <x-slot:title>{{ $request -> title }}</x-slot:title>
                                <x-slot:description>{{ $request -> description }}</x-slot:description>
                                <x-slot:tag>
                                    @foreach ($request->requestTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                                <x-slot:date>{{ date( 'Y.m.d', strtotime( $request  -> created_at ) ) }}</x-slot:date>
                                <x-slot:likes>{{ count($request -> requestLikes) }}</x-slot:likes>
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
    </div>
</x-mypage-app>
