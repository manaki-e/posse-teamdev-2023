<x-mypage-app>
    <x-slot:border_color>border-pink-600</x-slot:border_color>
    <x-slot:title>参加予約したイベント一覧</x-slot:title>
    <x-slot:earned_point>580</x-slot:earned_point>
    <x-slot:distribution_point>5000</x-slot:distribution_point>

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
                            開催キャンセル
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                    <ul class="border-b border-gray-300">
                        @foreach ($before_held_joined_events as $event)
                        <li>
                            <x-mypage-event-list>
                                <x-slot:title>{{ $event -> title }}</x-slot:title>
                                <x-slot:description>{{ $event -> description }}</x-slot:description>
                                <x-slot:tag>
                                    @foreach ($event->eventTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                                <x-slot:date>{{ $event  -> date ? date( 'Y.m.d', strtotime( $event  -> date ) ) : '未定' }}</x-slot:date>
                                <x-slot:style>{{ $event -> style ?? '未定' }}</x-slot:style>
                                <x-slot:participants_count>{{ count($event -> eventParticipants) }}</x-slot:participants_count>
                                <x-slot:create_date>{{ date( 'Y.m.d', strtotime( $event  -> created_at ) ) }}</x-slot:create_date>
                                <x-slot:likes>{{ count($event -> eventLikes) }}</x-slot:likes>
                                <x-slot:user_icon>{{ $event  -> user -> icon }}</x-slot:user_icon>
                                <x-slot:user_name>{{ $event  -> user -> name }}</x-slot:user_name>
                                <x-slot:status></x-slot:status>
                                <x-slot:timestamp></x-slot:timestamp>
                                <x-slot:button>
                                    <x-mypage-button-event-cancel action="{{ route('events.cancel', ['event' =>  $event -> id]) }}">
                                        <x-slot:content>予約をキャンセルする</x-slot:content>
                                        <x-slot:logo_path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                        </x-slot:logo_path>
                                        <x-slot:modal_title>イベントへの参加予定をキャンセル</x-slot:modal_title>
                                        <x-slot:modal_description>参加をキャンセルすると、主催者にポイントは入りません。ただし、自分自身にポイントは戻ってこないため、ご注意ください。</x-slot:modal_description>
                                        <x-slot:method></x-slot:method>
                                        <x-slot:form_slot></x-slot:form_slot>
                                    </x-mypage-button-event-cancel>
                                </x-slot:button>
                            </x-mypage-event-list>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div :class="{ '!block': activeTab === 2 }" x-show.transition.in.opacity.duration.600="activeTab === 2" class="hidden">
                    <ul class="border-b border-gray-300">
                        @foreach ($after_held_joined_events as $event)
                        <li>
                            <x-mypage-event-list>
                                <x-slot:title>{{ $event -> title }}</x-slot:title>
                                <x-slot:description>{{ $event -> description }}</x-slot:description>
                                <x-slot:tag>
                                    @foreach ($event->eventTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                                <x-slot:date>{{ $event  -> date ? date( 'Y.m.d', strtotime( $event  -> date ) ) : '未定' }}</x-slot:date>
                                <x-slot:style>{{ $event -> style ?? '未定' }}</x-slot:style>
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
                <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                    <ul class="border-b border-gray-300">
                        @foreach ($cancelled_joined_events as $event)
                        <li>
                            <x-mypage-event-list>
                                <x-slot:title>{{ $event -> title }}</x-slot:title>
                                <x-slot:description>{{ $event -> description }}</x-slot:description>
                                <x-slot:tag>
                                    @foreach ($event->eventTags as $tag)
                                    <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                    @endforeach
                                </x-slot:tag>
                                <x-slot:date>{{ $event  -> date ? date( 'Y.m.d', strtotime( $event  -> date ) ) : '未定' }}</x-slot:date>
                                <x-slot:style>{{ $event -> style ?? '未定' }}</x-slot:style>
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
    </div>
</x-mypage-app>
