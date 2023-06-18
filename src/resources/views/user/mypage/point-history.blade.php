<x-mypage-app>
    <x-slot:border_color>border-peer-perk</x-slot:border_color>
    <x-slot:title>ポイント移行履歴</x-slot:title>
    <x-slot:earned_point>{{ Auth::user()->earned_point }}</x-slot:earned_point>
    <x-slot:distribution_point>{{ Auth::user()->distribution_point }}</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-peer-perk hover:text-peer-perk" :class="{'relative text-peer-perk after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-peer-perk': activeTab === 0}">
                            Peer Point
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-peer-perk hover:text-peer-perk" :class="{'relative text-peer-perk after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-peer-perk': activeTab === 1}">
                            Bonus Point
                        </a>
                    </li>
                </ul>
            </div>
            <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                <ul class="border-b border-gray-300">
                    @foreach ($distribution_point_logs as $point_log)
                    <li>
                        <x-mypage-point-history-list>
                            <x-slot:app>{{ $point_log["app"] }}</x-slot:app>
                            <x-slot:name>{{ $point_log["name"] }}</x-slot:name>
                            <x-slot:created_at>{{ $point_log["created_at"] }}</x-slot:created_at>
                            <x-slot:point>{{ $point_log["point"] ? $point_log["point"] . " pt" : "0 pt" }}</x-slot:point>
                        </x-mypage-point-history-list>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                <ul class="border-b border-gray-300">
                    @foreach ($earned_point_logs as $point_log)
                    <li>
                        <x-mypage-point-history-list>
                            <x-slot:app>{{ $point_log["app"] }}</x-slot:app>
                            <x-slot:name>{{ $point_log["name"] }}</x-slot:name>
                            <x-slot:created_at>{{ $point_log["created_at"] }}</x-slot:created_at>
                            <x-slot:point>{{ $point_log["point"] ? $point_log["point"] . " pt" : "0 pt" }}</x-slot:point>
                        </x-mypage-point-history-list>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-mypage-app>
