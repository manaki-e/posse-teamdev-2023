<x-user-app>
    <x-slot name="header_slot">
        <x-user-header textColor="text-blue-400" bgColor="bg-blue-400">
            <x-slot:app_name>Peer Product Share</x-slot:app_name>
            <x-slot:button_text>アイテム登録</x-slot:button_text>
            <x-slot:button_link>{{ route('items.create') }}</x-slot:button_link>
            <x-slot:earned_point>{{Auth::user()->earned_point}}</x-slot:earned_point>
            <x-slot:distribution_point>{{Auth::user()->distribution_point}}</x-slot:distribution_point>
        </x-user-header>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-side-navi>
            <div class="mx-auto max-w-5xl">
                <x-user-search-box bgColor="bg-blue-400">
                    <x-user-search-tags>
                        <x-slot name="category1">利用状況</x-slot>
                        <x-slot name="available">貸出可能</x-slot>
                        <x-slot name="available_value">2</x-slot>
                        <x-slot name="unavailable">貸出中</x-slot>
                        <x-slot name="unavailable_value">3</x-slot>
                        <x-slot name="name">status</x-slot>
                        <x-slot name="category_tags">
                            @foreach($product_tags as $key=>$value)
                            <div class="w-auto mx-1 border rounded border-gray-200">
                                <div class="flex items-center px-3">
                                    <input name="tag"  id="{{$value->id}}" type="checkbox" value="{{ $value->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded filter-input">
                                    <label for="{{$value->id}}" class="w-full py-3 pl-1 text-sm font-medium text-gray-900">{{ $value->name }}</label>
                                </div>
                            </div>
                            @endforeach
                        </x-slot>
                    </x-user-search-tags>
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
                                            <div class="flex justify-between">
                                                <p class="mt-1">{{$product->point}} pt</p>
                                                <div class="flex relative">
                                                    <button class="mt-1 text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                        </svg>
                                                    </button>
                                                    <div class="mt-3">
                                                        <p class="text-xs">{{$product->product_likes_count}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        {{ $productsPaginated->withPath(url('/items'))->links() }}
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
            // Get the value of the clicked status input and put them in a integer variable
            let checkedStatus=document.querySelector('input[name=status]:checked');
            let checkedStatusValue;
            if(checkedStatus===null){
                checkedStatusValue=null;
            }else{
                checkedStatusValue=checkedStatus.value;
            }
            // console.log(checkedStatusValue);
            // Get the value of the clicked tags input and put them in an array
            let checkedTags=Array.from(document.querySelectorAll('input[name=tag]:checked'));
            let checkedTagsValues=checkedTags.map(e=>e.value);
            // console.log(checkedTagsValues);
            // Get all filter targets
            let filterTargets = document.querySelectorAll('.filter-target');

            // Show/hide targets based on the integer variable checkedStatus and array variable checkedTags
            filterTargets.forEach(filterTarget => {
                //get common tags
                let commonTags=checkedTagsValues.filter(value => JSON.parse(filterTarget.dataset.tag).includes(value));
                let commonTagsExist;
                //タグラジオが空ではなく、productのタグが空の場合タグによる絞り込みする判定
                console.log(JSON.parse(filterTarget.dataset.tag));
                if(filterTarget.dataset.tag.length===0&&checkedTagsValues.length!==0){
                    commonTagsExist=false;
                }
                //タグラジオが空の場合タグによる絞り込みなし判定
                if(checkedTagsValues.length===0){
                    commonTagsExist=true;
                }else{
                    commonTagsExist=commonTags.length>=1;
                }
                console.log('common'+commonTagsExist);
                //ステータスが空の場合
                if(checkedStatusValue===null){
                    //タグラジオが空の場合
                    if(checkedTagsValues.length===0){
                        // console.log('status and tags null')
                        filterTarget.style.display = 'block';
                    }else if(commonTagsExist){
                        // console.log('status null and true');
                        filterTarget.style.display = 'block';
                    }else{
                        // console.log('status null and false');
                        filterTarget.style.display = 'none';
                    }
                //ステータスとタグが一致する場合
                }else if(checkedStatusValue == filterTarget.dataset.status && commonTagsExist){
                    // console.log('true2');
                    filterTarget.style.display = 'block';
                }else{
                    // console.log('false2');
                    // console.log(checkedStatusValue);
                    // console.log(filterTarget.dataset.status);
                    filterTarget.style.display = 'none';
                }
            });
        });
    });
</script>
