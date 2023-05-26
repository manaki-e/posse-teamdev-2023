<x-mypage-app>
    <x-slot:border_color>border-pink-600</x-slot:border_color>
    <x-slot:title>主催したイベント一覧</x-slot:title>
    <x-slot:earned_point>{{ Auth::user()->earned_point }}</x-slot:earned_point>
    <x-slot:distribution_point>{{ Auth::user()->distribution_point }}</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-pink-600 hover:text-pink-600" :class="{'relative text-pink-600 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-pink-600': activeTab === 0}">
                            開催前
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-pink-600 hover:text-pink-600" :class="{'relative text-pink-600 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-pink-600': activeTab === 1}">
                            開催済み
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 2" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-pink-600 hover:text-pink-600" :class="{'relative text-pink-600 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-pink-600': activeTab === 2}">
                            開催中止
                        </a>
                    </li>
                </ul>
            </div>
            <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                <ul class="border-b border-gray-300">
                    @foreach ($before_held_events as $event)
                    <li>
                        <x-mypage-event-list>
                            <x-slot:id>{{ $event -> id }}</x-slot:id>
                            <x-slot:is_liked>{{ $event -> isLiked }}</x-slot:is_liked>
                            <x-slot:fill>@if($event->isLiked) red @else none @endif</x-slot:fill>
                            <x-slot:title>{{ $event -> title }}</x-slot:title>
                            <x-slot:description>{{ $event -> description }}</x-slot:description>
                            <x-slot:tag>
                                @foreach ($event->eventTags as $tag)
                                <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                @endforeach
                            </x-slot:tag>
                            <x-slot:start_date>{{ $event  -> start_date ? date( 'Y.m.d H:i', strtotime( $event  -> start_date ) ) : '未定' }}</x-slot:start_date>
                            <x-slot:end_date>{{ $event  -> end_date ? date( 'Y.m.d H:i', strtotime( $event  -> end_date ) ) : '未定' }}</x-slot:end_date>
                            <x-slot:style>{{ $event -> location ?? '未定' }}</x-slot:style>
                            <x-slot:participants_count>{{ count($event -> eventParticipants) }}</x-slot:participants_count>
                            <x-slot:create_date>{{ date( 'Y.m.d', strtotime( $event  -> created_at ) ) }}</x-slot:create_date>
                            <x-slot:likes>{{ count($event -> eventLikes) }}</x-slot:likes>
                            <x-slot:user_icon>{{ $event  -> user -> icon }}</x-slot:user_icon>
                            <x-slot:user_name>{{ $event  -> user -> name }}</x-slot:user_name>
                            <x-slot:status></x-slot:status>
                            <x-slot:timestamp></x-slot:timestamp>
                            <x-slot:button>
                                <div class="whitespace-nowrap flex flex-col gap-2">
                                    <x-mypage-button-event-held action="{{ route('events.held', ['event' =>  $event -> id]) }}">
                                        <x-slot:content>開催済み</x-slot:content>
                                        <x-slot:logo_path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
                                        </x-slot:logo_path>
                                        <x-slot:modal_title>主催したイベントを開催済みにする</x-slot:modal_title>
                                        <x-slot:modal_description>イベントが開催されたら、開催済みにしてください。開催済みにすることで、参加者からのポイントを受け取ることができます。一度開催済みにすると、解除できません。</x-slot:modal_description>
                                        <x-slot:method></x-slot:method>
                                        <x-slot:form_slot></x-slot:form_slot>
                                    </x-mypage-button-event-held>
                                    <x-mypage-button-event-cancel action="{{ route('events.cancel', ['event' =>  $event -> id]) }}">
                                        <x-slot:content>開催中止</x-slot:content>
                                        <x-slot:logo_path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                        </x-slot:logo_path>
                                        <x-slot:modal_title>主催したイベントを開催済みにする</x-slot:modal_title>
                                        <x-slot:modal_description>イベントが開催されたら、開催済みにしてください。開催済みにすることで、参加者からのポイントを受け取ることができます。一度開催済みにすると、解除できません。</x-slot:modal_description>
                                        <x-slot:method></x-slot:method>
                                        <x-slot:form_slot></x-slot:form_slot>
                                    </x-mypage-button-event-cancel>
                                </div>
                            </x-slot:button>
                            <div x-data="{ showModal: false }" x-on:keydown.window.escape="showModal = false" class="absolute top-0 right-0">
                                <div class="flex justify-center">
                                    <a @click="showModal = !showModal">
                                        <button class="middle none center font-sans py-3 px-2 text-xs font-bold uppercase text-gray-700 transition-all hover:opacity-75 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-dark="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                                <ul x-cloak x-show="showModal" x-transitio class="absolute z-10 w-28 overflow-auto rounded-md border border-blue-gray-50 bg-white font-sans text-sm font-normal text-blue-gray-500 shadow-lg shadow-blue-gray-500/10 focus:outline-none">
                                    <li role="menuitem" class="hover:bg-gray-300 block w-full cursor-pointer select-none px-3 py-4 text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
                                        <x-mypage-button-edit href="{{ route('events.edit', ['event' =>  $event -> id]) }}"></x-mypage-button-edit>
                                    </li>
                                    <li role="menuitem" class="hover:bg-gray-300 block w-full cursor-pointer select-none px-3 py-4 text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
                                        <x-mypage-button-delete action="{{ route('events.destroy', ['event' =>  $event -> id]) }}">
                                            <x-slot name="modal_title">
                                                {{ $event -> title }}を削除しますか？
                                            </x-slot>
                                            <x-slot name="modal_description">
                                                対象のイベントを削除します。一度削除すると復元できません。
                                            </x-slot>
                                        </x-mypage-button-delete>
                                    </li>
                                </ul>
                            </div>
                        </x-mypage-event-list>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                <ul class="border-b border-gray-300">
                    @foreach ($after_held_events as $event)
                    <li>
                        <x-mypage-event-list>
                            <x-slot:title>{{ $event -> title }}</x-slot:title>
                            <x-slot:description>{{ $event -> description }}</x-slot:description>
                            <x-slot:tag>
                                @foreach ($event->eventTags as $tag)
                                <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                @endforeach
                            </x-slot:tag>
                            <x-slot:start_date>{{ $event  -> start_date ? date( 'Y.m.d H:i', strtotime( $event  -> start_date ) ) : '未定' }}</x-slot:start_date>
                            <x-slot:end_date>{{ $event  -> end_date ? date( 'Y.m.d H:i', strtotime( $event  -> end_date ) ) : '未定' }}</x-slot:end_date> <x-slot:style>{{ $event -> style ?? '未定' }}</x-slot:style>
                            <x-slot:participants_count>{{ count($event -> eventParticipants) }}</x-slot:participants_count>
                            <x-slot:create_date>{{ date( 'Y.m.d', strtotime( $event  -> created_at ) ) }}</x-slot:create_date>
                            <x-slot:likes>{{ count($event -> eventLikes) }}</x-slot:likes>
                            <x-slot:user_icon>{{ $event  -> user -> icon }}</x-slot:user_icon>
                            <x-slot:user_name>{{ $event  -> user -> name }}</x-slot:user_name>
                            <x-slot:status>開催済み</x-slot:status>
                            <x-slot:timestamp>{{ date( 'Y.m.d', strtotime( $event  -> completed_at ) ) }}</x-slot:timestamp>
                            <x-slot:button></x-slot:button>
                        </x-mypage-event-list>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div :class="{ '!block': activeTab === 2 }" x-show.transition.in.opacity.duration.600="activeTab === 2" class="hidden">
                <ul class="border-b border-gray-300">
                    @foreach ($cancelled_events as $event)
                    <li>
                        <x-mypage-event-list>
                            <x-slot:title>{{ $event -> title }}</x-slot:title>
                            <x-slot:description>{{ $event -> description }}</x-slot:description>
                            <x-slot:tag>
                                @foreach ($event->eventTags as $tag)
                                <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                @endforeach
                            </x-slot:tag>
                            <x-slot:start_date>{{ $event  -> start_date ? date( 'Y.m.d H:i', strtotime( $event  -> start_date ) ) : '未定' }}</x-slot:start_date>
                            <x-slot:end_date>{{ $event  -> end_date ? date( 'Y.m.d H:i', strtotime( $event  -> end_date ) ) : '未定' }}</x-slot:end_date> <x-slot:style>{{ $event -> style ?? '未定' }}</x-slot:style>
                            <x-slot:participants_count>{{ count($event -> eventParticipants) }}</x-slot:participants_count>
                            <x-slot:create_date>{{ date( 'Y.m.d', strtotime( $event  -> created_at ) ) }}</x-slot:create_date>
                            <x-slot:likes>{{ count($event -> eventLikes) }}</x-slot:likes>
                            <x-slot:user_icon>{{ $event  -> user -> icon }}</x-slot:user_icon>
                            <x-slot:user_name>{{ $event  -> user -> name }}</x-slot:user_name>
                            <x-slot:status>中止</x-slot:status>
                            <x-slot:timestamp>{{ date( 'Y.m.d', strtotime( $event  -> cancelled_at ) ) }}</x-slot:timestamp>
                            <x-slot:button></x-slot:button>
                        </x-mypage-event-list>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-mypage-app>
