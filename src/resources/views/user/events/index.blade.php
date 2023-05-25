<x-user-app>
    <x-slot name="header_slot">
        <x-user-header textColor="text-pink-600" bgColor="bg-pink-600">
            <x-slot:app_name>Peer Event</x-slot:app_name>
            <x-slot:button_text>イベント登録</x-slot:button_text>
            <x-slot:button_link>{{ route('events.create') }}</x-slot:button_link>
            <x-slot:earned_point>{{ Auth::user()->earned_point }}</x-slot:earned_point>
            <x-slot:distribution_point>{{ Auth::user()->distribution_point }}</x-slot:distribution_point>
        </x-user-header>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-side-navi>
            <div class="mx-auto max-w-5xl">
                <x-user-search-box bgColor="bg-pink-600">
                    <x-user-search-event>
                        <x-slot name="filter_by_tags">
                            <x-user-search-tags>
                                <x-slot name="category_tags">
                                    @foreach ($tags as $index => $tag)
                                    <div class="w-auto mx-1 border rounded border-gray-200">
                                        <div class="flex items-center px-3">
                                            <input id="tag_{{ $index }}" type="checkbox" value="{{ $index }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                            <label for="tag_{{ $index }}" class="w-full py-3 pl-1 text-sm font-medium text-gray-900">{{ $tag->name }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </x-slot>
                            </x-user-search-tags>
                        </x-slot>
                    </x-user-search-event>
                </x-user-search-box>
                <div class="mx-auto max-w-5xl my-4">
                    <div class="mx-auto grid grid-cols-2 gap-4">
                        @foreach ($events as $event)
                        <div x-data="{ open: false }" class="col-span-1">
                            <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
                                <div class="rounded-lg text-xs shadow-md p-4 pb-1 text-gray-500 bg-white">
                                    <section>
                                        <!-- イベント名 -->
                                        <div class="w-full text-xl text-gray-800 mb-4">
                                            <p class="font-bold pl-2 border-l-4 border-pink-600">{{ $event->title }}</p>
                                        </div>
                                        <!-- タグ -->
                                        <div class="w-full">
                                            <div class="inline-flex flex-wrap mb-4">
                                                @foreach($event->eventTags as $event_tag)
                                                <span class="items-center gap-1 rounded-full border border-gray-300 bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-400">
                                                    {{ $event_tag->tag->name }}
                                                </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- データ -->
                                        <div class="relative flex mb-4">
                                            <div class="w-1/2 space-y-1 flex flex-col text-sm">
                                                <p>日程：{{ $event->show_date }}</p>
                                                <p>形態：{{ $event->location }}</p>
                                                <p>主催：
                                                    <!-- プロフィール参照機能できたら代入 -->
                                                    <span><a href="#" class="hover:border-gray-400 border-transparent border-b">{{ $event->user->name }}</a></span>
                                                </p>
                                            </div>
                                            <!-- ユーザーアイコン -->
                                            <div class="w-1/2 flex items-end justify-end -space-x-1">
                                                @foreach ($event->eventParticipants as $event_participant)
                                                <div x-data="{ tooltip: false }" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" class="h-8 w-8 relative">
                                                    <img class="h-full w-full rounded-full object-cover object-center ring ring-white" src="{{ $event_participant->user->icon }}" alt="icon" />
                                                    <div x-cloak x-show.transition.origin.top="tooltip" class="absolute w-20">{{ $event_participant->user->name }}</div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <div class="z-30 flex bg-gray-200 h-8 w-8 items-center justify-center overflow-hidden rounded-full ring ring-white">
                                                <button id="" class="h-full w-full inline-flex items-center justify-center rounded-full text-gray-700 shadow-sm align-middle">
                                                    <span class="leading-none">•••</span>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- いいね -->
                                        <div class="likes absolute top-0 right-0">
                                            <div class="flex relative">
                                                <button class="text-gray-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                    </svg>
                                                </button>
                                                <div class="mt-3">
                                                    @if($event)
                                                    <p class="text-xs">{{ dd($event->event_likes_count) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <!-- 概要 -->
                                    <div x-show="open" x-cloak>
                                        <div class="w-full text-sm text-gray-800 mb-4">
                                            <p class="pl-1 mb-1 border-l-2 border-pink-600">概要</p>
                                            <p class="text-gray-500"> 私は場合けっしてその安心院に従ってののためで被せるたない。
                                                やはり今が逡巡学はとうとうその学習だろざるかもを信ずるば行くだのも講演きまっででて、なぜにはできでなないん。</p>
                                        </div>
                                        <!-- モーダル -->
                                        <div x-data="{ modelOpen: false }">
                                            <div @click="modelOpen =!modelOpen" class="flex items-center justify-center px-3">
                                                <x-user-register-button textColor="text-pink-600" bgColor="bg-white" borderColor="border-pink-600">
                                                    <x-slot name="button">予約する</x-slot>
                                                </x-user-register-button>
                                            </div>

                                            <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                                    <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                                                    <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-40 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                                        <div class="flex items-center justify-between space-x-4">
                                                            <h1 class="text-xl font-semibold text-gray-800 pl-2 border-l-4 border-pink-600">参加予約</h1>
                                                            <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <p class="mt-2 text-sm text-gray-500 ">
                                                            主催者に支払うポイントを設定してください
                                                        </p>
                                                        <form class="mt-5">
                                                            <div>
                                                                <label class="block text-sm text-gray-700 capitalize dark:text-gray-200">参加ポイント</label>
                                                                <input type="number" step="10" min="0" max="500" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md" required />
                                                                <p class="ml-2 text-xs text-gray-500 ">
                                                                    ポイントの上限は 500 pt
                                                                </p>
                                                            </div>
                                                            <div class="mt-6">
                                                                <x-user-register-button textColor="text-white" bgColor="bg-pink-600" borderColor="border-pink-600">
                                                                    <x-slot name="button">予約する</x-slot>
                                                                </x-user-register-button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div @click="open=!open" class="mb-1 flex justify-center cursor-pointer rounded-md hover:bg-gray-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="block h-5 w-5 transform " :class="{ 'rotate-180' : open }">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </x-user-side-navi>
    </x-slot>
</x-user-app>
<style>
    [x-cloak] {
        display: none;
    }
</style>
<script>
    // Get all filter inputs
    let filterInputs = document.querySelectorAll('.filter-input');

    // Add event listener to each filter button
    filterInputs.forEach(input => {
        input.addEventListener('click', () => {
            //選択したステータスを変数にいれる
            let checkedStatus = document.querySelector('input[name=status]:checked');
            let checkedStatusValue;
            if (checkedStatus === null) {
                checkedStatusValue = null;
            } else {
                checkedStatusValue = checkedStatus.value;
            }
            // 選択したタグを配列に入れる
            let checkedTags = Array.from(document.querySelectorAll('input[name=tag]:checked'));
            let checkedTagsValues = checkedTags.map(e => e.value);
            // 絞り込み対象全て取得
            let filterTargets = document.querySelectorAll('.filter-target');

            // Show/hide targets based on the integer variable checkedStatus and array variable checkedTags
            filterTargets.forEach(filterTarget => {
                //ターゲットタグを配列に変換
                let targetTags = JSON.parse(filterTarget.dataset.tag);
                //ターゲットタグが空か判定
                let targetTagsEmpty = targetTags.length === 0;
                //インプットタグとターゲットタグの共通項を取得
                let commonTags = checkedTagsValues.filter(value => targetTags.includes(parseInt(value)));
                let filterByTags;
                //ターゲットステータスとステータスラジオの値が一致するか判定
                let statusEqual = filterTarget.dataset.status === checkedStatusValue;
                //インプットタグが空か判定
                let tagsNotChosen = checkedTagsValues.length === 0;
                //ステータスラジオが空か判定
                let statusNotChosen = checkedStatusValue === null;
                //インプットタグとターゲットタグの共通項が空か判定
                let commonTagsEmpty = commonTags.length === 0;

                //共通タグ、選択したタグ、ターゲットタグをコンソールに表示＝＞デバッグ用
                console.log(commonTags, checkedTagsValues, targetTags);

                //ターゲットタグが空かつインプットタグが空ではない場合タグによる絞り込みは偽判定
                if (targetTagsEmpty && !tagsNotChosen) {
                    filterByTags = false;
                }
                //インプットタグが空の場合タグによる絞り込みは真判定
                else if (tagsNotChosen) {
                    filterByTags = true;
                }
                //インプットタグとターゲットタグの共通項がある場合タグによる絞り込みは偽判定
                else if (commonTagsEmpty) {
                    filterByTags = false;
                }
                //インプットタグとターゲットタグの共通項がない場合タグによる絞り込みは真判定
                else if (!commonTagsEmpty) {
                    filterByTags = true;
                }
                if (statusNotChosen) {
                    if (filterByTags) {
                        filterTarget.style.display = 'block';
                    } else {
                        filterTarget.style.display = 'none';
                    }
                } else if (statusEqual && filterByTags) {
                    filterTarget.style.display = 'block';
                } else {
                    filterTarget.style.display = 'none';
                }
            });
        });
    });
</script>
