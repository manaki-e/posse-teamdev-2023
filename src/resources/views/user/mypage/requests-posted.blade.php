<x-mypage-app>
    <x-slot:title>投稿したリクエスト一覧</x-slot:title>
    <x-slot:earned_point>580</x-slot:earned_point>
    <x-slot:distribution_point>5000</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-400 hover:text-blue-400" :class="{'relative text-blue-400  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-400': activeTab === 0}">
                            未解決
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-400 hover:text-blue-400" :class="{'relative text-blue-400  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-400': activeTab === 1}">
                            解決済み
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                    <ul class="border-b border-gray-300">
                        @foreach ($resolved_requests as $request)
                        <li>
                            <x-mypage-request-list>
                                <x-slot:title>{{ $request -> title }}</x-slot:title>
                                <x-slot:description>{{ $request -> description }}</x-slot:description>
                                <x-slot:likes></x-slot:likes>
                                <x-slot:tag>
                                    @foreach ($request->requestTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                                <x-slot:button>
                                    <x-mypage-button-edit href="{{ route('items.edit', ['item' =>  $request -> id]) }}"></x-mypage-button-edit>
                                    <x-mypage-button-delete action="{{ route('items.destroy', ['item' =>  $request -> id]) }}">
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
                        @foreach ($unresolved_requests as $request)
                        <li>
                            <x-mypage-request-list>
                                <x-slot:title>{{ $request -> title }}</x-slot:title>
                                <x-slot:description>{{ $request -> description }}</x-slot:description>
                                <x-slot:likes></x-slot:likes>
                                <x-slot:tag>
                                    @foreach ($request->requestTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
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
