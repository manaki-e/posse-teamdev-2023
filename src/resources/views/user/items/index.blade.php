<x-user-app>
    <x-slot name="header_slot">
        <x-user-header textColor="text-blue-400" bgColor="bg-blue-400">
            <x-slot:app_name>Peer Product Share</x-slot:app_name>
            <x-slot:button_text>アイテム登録</x-slot:button_text>
            <x-slot:button_link>{{ route('items.create') }}</x-slot:button_link>
            <x-slot:earned_point>{{Auth::user()->earned_point}}</x-slot:earned_point>
            <x-slot:distribution_point>{{Auth::user()->distribution_point}}</x-slot:distribution_point>
            <x-slot:top_title_link>{{ route('items.index') }}</x-slot:top_title_link>
        </x-user-header>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-side-navi>
            <div class="mx-auto max-w-5xl">
                <x-user-search-box bgColor="bg-blue-400">
                    <x-user-search-item bgColor="bg-blue-400">
                        <x-slot name="filter_by_radio">
                            <x-user-search-radio>
                                <x-slot name="radio_name">利用状況</x-slot>
                                <x-slot name="radios">
                                    @foreach($filter_statuses as $key=>$filter_status)
                                    <div class="flex items-center mb-4">
                                        <input id="box-{{ $key }}" type="radio" value="{{ $key }}" name="status" class="w-4 h-4 bg-gray-100 border-gray-300 filter-input">
                                        <label for="box-{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $filter_status  }}</label>
                                    </div>
                                    @endforeach
                                </x-slot>
                            </x-user-search-radio>
                        </x-slot>
                        <x-slot name="filter_by_tags">
                            <x-user-search-tags>
                                <x-slot name="category_tags">
                                    @foreach($product_tags as $key=>$value)
                                    <div class="w-auto mx-1 border rounded border-gray-200">
                                        <div class="flex items-center px-3">
                                            <input name="tag" id="{{$value->id}}" type="checkbox" value="{{ $value->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded filter-input">
                                            <label for="{{$value->id}}" class="w-full py-3 pl-1 text-sm font-medium text-gray-900">{{ $value->name }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </x-slot>
                            </x-user-search-tags>
                        </x-slot>
                    </x-user-search-item>
                </x-user-search-box>

                <section class="text-gray-600 body-font mx-auto max-w-5xl">
                    <div class="py-12 mx-auto">
                        <div class="grid grid-cols-4 gap-8 mb-8">
                            @foreach ($products as $product)
                            <div data-status="{{ $product->status }}" data-tag="{{ $product->data_tag  }}" class="col-span-1 filter-target">
                                <a href="/items/{{$product->id}}">
                                    <div class="shadow-md">
                                        <div class="bg-white relative h-48 rounded overflow-hidden">
                                            <img alt="ecommerce" class="object-cover object-center w-full h-full block" src=" {{asset('images/'.$product->productImages->first()->image_url)}}">
                                            @if ( $product->japanese_status !== '貸出可能' )
                                            <span class="absolute left-0 top-0 rounded-br-lg bg-red-500 px-3 py-1.5 text-sm uppercase tracking-wider text-white">
                                                貸出中
                                            </span>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h2 class="text-gray-900 title-font text-lg font-medium">{{$product->title}}</h2>
                                            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">
                                                {!! $product->description !!}
                                            </h3>
                                        </div>
                                </a>
                                <div class="p-4 flex justify-between">
                                    <p class="mt-1">{{$product->point}} pt</p>
                                    <div class="flex relative likes" data-product_id="{{ $product->id }}" data-is_liked="{{ $product->isLiked }}">
                                        <button class="mt-1 text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                        </button>
                                        <div class="mt-3">
                                            <p class="text-xs like-count">{{$product->product_likes_count}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </x-user-side-navi>

    </x-slot>
</x-user-app>
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
    let likes = document.querySelectorAll('.likes');
    //foreach likes, if clicked, change color and send ajax product to route('products.like') or route('products.unlike')
    likes.forEach(like => {
        like.addEventListener('click', () => {
            //get isLiked data from element
            let isLiked = like.dataset.is_liked;
            //get product id from element
            let productId = like.dataset.product_id;
            //get like count element
            let likeCount = like.querySelector('.like-count');
            //if isLiked is true, send unlike product
            if (isLiked === '1') {
                
                axios.post('/items/' + productId + '/unlike')
                    .then(function(response) {
                        //change isLiked data to false
                        like.setAttribute('data-is_liked', 0);
                        //change svg color to gray
                        like.querySelector('svg').style.fill = 'none';
                        //decrease like count
                        likeCount.innerHTML = parseInt(likeCount.innerHTML) - 1;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }
            //if isLiked is false, send like product
            else {
                axios.post('/items/' + productId + '/like')
                    .then(function(response) {
                        //change isLiked data to true
                        like.setAttribute('data-is_liked', 1);
                        //change svg color to red
                        like.querySelector('svg').style.fill = 'red';
                        //increase like count
                        likeCount.innerHTML = parseInt(likeCount.innerHTML) + 1;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }
        });
    });
</script>
