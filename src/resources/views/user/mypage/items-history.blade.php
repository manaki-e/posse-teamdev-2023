<x-mypage-app>
    <x-slot:border_color>border-blue-400</x-slot:border_color>
    <x-slot:title>取引履歴</x-slot:title>
    <x-slot:earned_point>{{ Auth::user()->earned_point }}</x-slot:earned_point>
    <x-slot:distribution_point>{{ Auth::user()->distribution_point }}</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-400 hover:text-blue-400" :class="{'relative text-blue-400 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-400': activeTab === 0}">
                            借用履歴
                        </a>
                    </li>
                    <li>
                        <a @click="activeTab = 1" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-400 hover:text-blue-400" :class="{'relative text-blue-400 after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-400': activeTab === 1}">
                            貸出履歴
                        </a>
                    </li>
                </ul>
            </div>
            <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                <div class="overflow-hidden border-y border-gray-200 mb-4">
                    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900">商品情報</th>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">貸出日時</th>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">返却日時</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 border-t border-gray-200">
                            @foreach ( $borrow_product_histories as $history )
                            <x-mypage-history-item>
                                <x-slot:id>{{ $history -> product -> id }}</x-slot:id>
                                <x-slot:image_url>{{ $history -> product -> productImages[0] -> image_url }}</x-slot:image_url>
                                <x-slot:title>{{ $history -> product -> title }}</x-slot:title>
                                <x-slot:point>{{ $history->point .' pt'}}</x-slot:point>
                                <x-slot:user_icon>{{ $history -> product -> user -> icon }}</x-slot:user_icon>
                                <x-slot:user_name>{{ $history -> product -> user -> name }}</x-slot:user_name>
                                <x-slot:borrowing_time>{{ date( 'Y年m月d日', strtotime( $history -> created_at ) ) }}</x-slot:borrowing_time>
                                <x-slot:return_time>
                                    @if($history -> cancelled_at)
                                    キャンセル済み
                                    @elseif($history -> returned_at)
                                    {{ date('Y年m月d日',strtotime($history -> returned_at)) }}
                                    @else
                                    未返却
                                    @endif
                                </x-slot:return_time>
                            </x-mypage-history-item>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div :class="{ '!block': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1" class="hidden">
                <div class="overflow-hidden border-y border-gray-200 mb-4">
                    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900">商品情報</th>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900">貸出者</th>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">貸出日時</th>
                                <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">返却日時</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 border-t border-gray-200">
                            @foreach ( $lend_product_histories as $history )
                            <x-mypage-history-item>
                                <x-slot:id>{{ $history -> product -> id }}</x-slot:id>
                                <x-slot:image_url>{{ $history -> product -> productImages[0] -> image_url }}</x-slot:image_url>
                                <x-slot:title>{{ $history -> product -> title }}</x-slot:title>
                                <x-slot:point>{{ $history->point .' pt'}}</x-slot:point>
                                <x-slot:user_icon>{{ $history -> product -> user -> icon }}</x-slot:user_icon>
                                <x-slot:user_name>{{ $history -> product -> user -> name }}</x-slot:user_name>
                                <x-slot:borrowing_time>{{ date( 'Y年m月d日', strtotime( $history -> created_at ) ) }}</x-slot:borrowing_time>
                                <x-slot:return_time>
                                    @if($history -> cancelled_at)
                                    キャンセル済み
                                    @elseif($history -> returned_at)
                                    {{ date('Y年m月d日',strtotime($history -> returned_at)) }}
                                    @else
                                    未返却
                                    @endif </x-slot:return_time>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-nowrap gap-2">
                                        <img src="{{ $history -> user -> icon }}" alt="ユーザアイコン" class="w-6 h-6 rounded-full object-cover object-center">
                                        <span class="flex-center text-xs font-bold">{{ $history -> user -> name }}</span>
                                    </div>
                                </td>
                            </x-mypage-history-item>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-mypage-app>
