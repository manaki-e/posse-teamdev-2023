<x-user-app>
    <x-slot name="header_slot">
        <x-user-header textColor="text-blue-400" bgColor="bg-blue-400">
            <x-slot:app_name>Peer Product Share</x-slot:app_name>
            <x-slot:button_link>{{ route('items.create') }}</x-slot:button_link>
            <x-slot:button_text>アイテム登録</x-slot:button_text>
            <x-slot:top_title_link>{{ route('items.index') }}</x-slot:top_title_link>
        </x-user-header>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-side-navi>
            <div class="w-full mx-auto">
                <x-user-form method="POST" action="{{ route('items.update',$product->id) }}" enctype="multipart/form-data">
                    <x-slot name="title">アイテムの編集</x-slot>
                    <section class="text-left w-full flex gap-8">
                        <div class="w-1/2">
                            <div class="mx-auto mt-6">
                                <label for="file" class="mb-1 block text-sm font-medium text-gray-700">出品画像<span class="text-red-600">*</span><span class="text-xs text-gray-400">（最大５枚まで）</span></label>
                                <label class="relative flex w-full cursor-pointer appearance-none items-center justify-center rounded-md border-2 border-dashed border-gray-200 p-6 transition-all hover:border-gray-300 overflow-x-scroll">
                                    <div class="space-y-1 text-center">
                                        <div>削除する画像を選択</div>
                                        @foreach($product->productImages as $product_image)
                                        <label>
                                            <img width="100" height="100" src="{{asset('images/'.$product_image->image_url)}}">
                                            <input value="{{$product_image->id}}" type="checkbox" name="delete_images[]">
                                            {{ $product_image->image_url }}
                                        </label>
                                        @endforeach
                                        <div class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-gray-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                            </svg>
                                        </div>
                                        <div class="text-gray-600"><a href="#" class="font-medium text-primary-500 hover:text-primary-700">クリックして追加</a>
                                            または ファイルをドロップ</div>
                                        <p class="text-sm text-gray-500">SVG, PNG or JPG (max. 1MB, 3枚まで)</p>
                                    </div>
                                    <input id="file" type="file" name="product_images[]" class="sr-only" multiple required onchange="checkFileSize(this),preview(this)" />
                                    <div class="preview-area "></div>
                                </label>
                            </div>
                            <section class="my-6">
                                <h3 class="mb-2 text-xl text-gray-600 font-extrabold border-b border-gray-500">アイテムの詳細
                                </h3>
                                <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">カテゴリ</h4>
                                <div class="w-full flex flex-wrap max-w-lg text-sm font-medium text-gray-900 bg-white">
                                    @foreach ($product_tags as $index => $tag)
                                    <div class="min-w-max m-1 border rounded border-gray-200">
                                        <div class="flex items-center px-3">
                                            <input id="tag_{{ $index }}" type="checkbox" value="{{ $tag->id }}" name="product_tags[]" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" @if($tag->is_chosen) checked @endif>
                                            <label for="tag_{{ $index }}" class="w-auto py-3 pl-1 text-sm font-medium text-gray-900">{{ $tag->name }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">アイテムの状態<span class="text-red-600">*</span></h4>
                                <div class="mb-4 border border-gray-300 rounded-md">
                                    <select name="condition" id="example1" class="p-1 block w-full rounded-md border-gray-300 shadow-sm text-base text-gray-500" required>
                                        @foreach($conditions as $key => $condition)
                                        <option value="{{ $key }}" @if($product->condition===$key) selected @endif>{{ $condition }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </section>
                        </div>

                        <section class="my-6 w-1/2">
                            <h3 class="mb-2 text-xl text-gray-600 font-extrabold border-b border-gray-500">アイテム名と説明</h3>
                            <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">アイテム名<span class="text-red-600">*</span></h4>
                            <div class="mx-auto">
                                <input value="{{ $product->title }}" name="title" type="text" class="p-1 block w-full rounded-md border border-gray-300" required />
                            </div>
                            <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">アイテムの説明<span class="text-red-600">*</span></h4>
                            <div class="mx-auto">
                                <textarea name="description" class="p-1 block w-full rounded-md border border-gray-300" rows="3" required>{{ $product->description }}</textarea>
                            </div>
                            <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">関連するリクエスト</h4>
                            <div class="mb-4 border border-gray-300 rounded-md">
                                <select name="request_id" id="example1" class="p-1 block w-full rounded-md border-gray-300 shadow-sm text-base text-gray-500">
                                    <option value="">なし</option>
                                    @foreach($requests as $request)
                                    @if($request->id===$product->request_id)
                                    <option value="{{ $request->id }}" selected>{{ $request->title }}</option>
                                    @else
                                    <option value="{{ $request->id }}">{{ $request->title }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </section>
                    </section>
                    <x-user-register-button textColor=" text-white" bgColor="bg-blue-400" borderColor="border-blue-400">
                        <x-slot name="button">
                            更新する
                        </x-slot>
                    </x-user-register-button>
                </x-user-form>
            </div>
        </x-user-side-navi>
    </x-slot>
</x-user-app>
<style>
    .preview-area {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        overflow-x: scroll;
    }

    .preview-area img {
        height: 100%;
        padding: 0 1rem;
        object-fit: contain;
        background-color: white;
        border: 0.5px solid gray;
    }
</style>
<script>
    function preview(elem, output = '') {
        Array.from(elem.files).map((file) => {
            const blobUrl = window.URL.createObjectURL(file)
            output += `<img src=${blobUrl}>`
        })
        elem.nextElementSibling.innerHTML = output
    }

    function checkFileSize(input) {
        const maxSize = 1 * 1024 * 1024; // 1MB in bytes
        const files = input.files;
        for (let i = 0; i < files.length; i++) {
            if (files[i].size > maxSize) {
                // File size exceeds the maximum limit
                alert('1MB以下の画像を選択してください.');
                input.value = null; // Clear the file input
                return;
            }
        }

        // Proceed with file preview or submission
        preview(input);
    }
</script>
