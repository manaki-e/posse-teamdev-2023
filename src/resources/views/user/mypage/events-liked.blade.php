<x-mypage-app>
    <x-slot:border_color>border-pink-600</x-slot:border_color>
    <x-slot:title>参加予約したイベント一覧</x-slot:title>
    <x-slot:earned_point>580</x-slot:earned_point>
    <x-slot:distribution_point>5000</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <div>
            <ul class="border-b border-gray-300">
                @foreach ($liked_events as $event)
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
                        <x-slot:button>
                            <!-- 自身が主催するイベントの場合 -->
                            @if ($event -> user_id === $user -> id)
                            <p class="text-red-500">自分が主催するイベントです。</p>
                            <!-- 自身が参加予定のイベントの場合 -->
                            @elseif ($event -> user_id === $user -> id)
                            <p class="text-red-500">すでに参加予約したイベントです。</p>
                            <!-- 開催前のイベントであった場合 -->
                            @elseif ($event -> user_id === $user -> id)
                            <x-mypage-button-event-held action="{{ route('events.participate', ['event' =>  $event -> id]) }}">
                                <x-slot:content>予約する</x-slot:content>
                                <x-slot:logo_path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </x-slot:logo_path>
                                <x-slot:modal_title>参加予約</x-slot:modal_title>
                                <x-slot:modal_description>主催者に支払うポイントを設定してください。一度支払ったポイントは戻ってこないのでご注意ください。</x-slot:modal_description>
                                <x-slot:method></x-slot:method>
                                <x-slot:form_slot>
                                    <label class="block text-sm text-gray-700 capitalize dark:text-gray-200">参加ポイント</label>
                                    <input type="number" step="10" min="0" max="500" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md" required />
                                    <p class="ml-2 text-xs text-gray-500 ">
                                        ポイントの上限は 500 pt
                                    </p>
                                </x-slot:form_slot>
                            </x-mypage-button-event-held>
                            @endif
                        </x-slot:button>
                    </x-mypage-event-list>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-mypage-app>
