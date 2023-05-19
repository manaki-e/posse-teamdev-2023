<x-mypage-app>
    <x-slot:title>出品したアイテム一覧</x-slot:title>
    <x-slot:earned_point>580</x-slot:earned_point>
    <x-slot:distribution_point>5000</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 0}">
                            出品中
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 1}">
                            貸出中
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 2" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 2}">
                            貸出申請中
                        </a>
                    </li>
                </ul>
            </div>
            <div class="py-3">
                <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                    <ul class="border-b border-gray-300">
                        <li>
                            <x-mypage-list>
                                <x-slot:title>共通テスト 英語(リーディング) 対策問題集 FinalSpurt 40</x-slot:title>
                                <x-slot:point>800</x-slot:point>
                                <x-slot:likes>14</x-slot:likes>
                                <x-slot:tag>
                                    @foreach (['英語', 'リーディング', '共通テスト'] as $tag)
                                    <li>
                                        <x-user-tag>{{ $tag }}</x-user-tag>
                                    </li>
                                    @endforeach
                                </x-slot:tag>
                            </x-mypage-list>
                        </li>
                        <li>
                            <x-mypage-list>
                                <x-slot:title>共通テスト 英語(リーディング) 対策問題集 FinalSpurt 40</x-slot:title>
                                <x-slot:point>800</x-slot:point>
                                <x-slot:likes>14</x-slot:likes>
                                <x-slot:tag>
                                    @foreach (['英語', 'リーディング', '共通テスト'] as $tag)
                                    <li>
                                        <x-user-tag>{{ $tag }}</x-user-tag>
                                    </li>
                                    @endforeach
                                </x-slot:tag>
                            </x-mypage-list>
                        </li>
                        <li>
                            <x-mypage-list>
                                <x-slot:title>共通テスト 英語(リーディング) 対策問題集 FinalSpurt 40</x-slot:title>
                                <x-slot:point>800</x-slot:point>
                                <x-slot:likes>14</x-slot:likes>
                                <x-slot:tag>
                                    @foreach (['英語', 'リーディング', '共通テスト'] as $tag)
                                    <li>
                                        <x-user-tag>{{ $tag }}</x-user-tag>
                                    </li>
                                    @endforeach
                                </x-slot:tag>
                            </x-mypage-list>
                        </li>
                    </ul>
                </div>
                <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                    <ul class="border-b border-gray-300">
                        <li>
                        </li>
                    </ul>
                </div>
                <div :class="{ '!block': activeTab === 2 }" x-show.transition.in.opacity.duration.600="activeTab === 2" class="hidden">
                    <ul class="border-b border-gray-300">
                        <li>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-mypage-app>
