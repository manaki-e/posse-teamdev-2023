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
                <x-user-form method="PUT" action="{{ route('items.update',$product->id) }}" enctype="multipart/form-data">
                    <x-slot name="title">アイテムの編集</x-slot>
                    <section class="text-left w-full flex gap-8">
                        <div class="w-1/2">
                            <div class="mx-auto mt-6">
                                <div class="mb-1 block text-sm font-medium text-gray-700">出品画像<span class="text-red-600">*</span><span class="text-xs text-gray-400">（最大3枚まで）</span></div>
                                <div class="relative flex flex-col w-full cursor-pointer appearance-none items-center justify-center rounded-md border-2 border-dashed border-gray-200 transition-all hover:border-gray-300 overflow-x-scroll">
                                    <div id="image-preview" class="preview-area overflow-x-scroll">
                                        <!-- 既存画像 -->
                                        @foreach ($product->productImages as $key => $product_image)
                                        <div>
                                            <img class="h-full" src="{{asset('images/'.$product_image->image_url)}}" alt="Image">
                                            <input hidden value="{{$product_image->id}}" type="checkbox" name="delete_images[]">
                                            <button type="button" class="delete-btn-pre absolute text-gray-700 top-0 right-0 bg-gray-100 rounded-full" data-key="{{ $key }}">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8 1C4.1 1 1 4.1 1 8C1 11.9 4.1 15 8 15C11.9 15 15 11.9 15 8C15 4.1 11.9 1 8 1ZM8 14C4.7 14 2 11.3 2 8C2 4.7 4.7 2 8 2C11.3 2 14 4.7 14 8C14 11.3 11.3 14 8 14Z" fill="currentColor" />
                                                    <path d="M10.7 11.5L8 8.8L5.3 11.5L4.5 10.7L7.2 8L4.5 5.3L5.3 4.5L8 7.2L10.7 4.5L11.5 5.3L8.8 8L11.5 10.7L10.7 11.5Z" fill="currentColor" />
                                                </svg>
                                            </button>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- 画像追加 -->
                                    <div class="mt-24 w-full flex justify-center">
                                        <input type="file" id="image-input" name="product_images[]" style="display: none;" multiple>
                                        <button type="button" id="add-btn" class="block rounded-lg my-2 mx-2 px-2 py-1 border border-gray-300 shadow text-center text-sm transition-all align-middle hover:shadow-md hover:opacity-75 ">画像を追加</button>
                                    </div>
                                </div>
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
        height: 6rem;
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        overflow-x: scroll;
    }

    .preview-area div {
        position: relative;
        max-height: 6rem;
        height: 100%;
        padding: 0 1rem;
        background-color: white;
        border: 0.5px solid gray;
    }

    .preview-area div img {
        height: 100%;
        width: auto;
        object-fit: contain;
    }

</style>
<script>
    // function preview(elem, output = '') {
    //     Array.from(elem.files).map((file) => {
    //         const blobUrl = window.URL.createObjectURL(file)
    //         output += `<img src=${blobUrl}>`
    //     })
    //     elem.nextElementSibling.innerHTML = output
    // }

    // function checkFileSize(input) {
    //     const maxSize = 1 * 1024 * 1024; // 1MB in bytes
    //     const files = input.files;
    //     for (let i = 0; i < files.length; i++) {
    //         if (files[i].size > maxSize) {
    //             // File size exceeds the maximum limit
    //             alert('1MB以下の画像を選択してください.');
    //             input.value = null; // Clear the file input
    //             return;
    //         }
    //     }

    //     // Proceed with file preview or submission
    //     preview(input);
    // }

    // 既存の画像削除ボタンのクリックイベント
    const deleteButtonsPre = document.querySelectorAll('.delete-btn-pre');
    deleteButtonsPre.forEach((button) => {
        button.addEventListener('click', function() {
            const checkbox = this.previousElementSibling;
            const imageElement = this.parentNode;
            checkbox.checked = true;
            imageElement.style.display = "none";
        });
    });

    // 画像追加ボタンのクリックイベント
    const addBtn = document.querySelector('#add-btn');
    const imageInput = document.querySelector('#image-input');
    const imagePreview = document.querySelector('#image-preview');

    addBtn.addEventListener('click', function() {
        imageInput.click();
    });

    imageInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = function(event) {
                const imageUrl = event.target.result;
                const imageElement = document.createElement('div');
                imageElement.innerHTML = `
        <img class="h-full" src="${imageUrl}" alt="${file.name}">
        <button type="button" class="delete-btn absolute top-0 right-0 bg-gray-100 rounded-full">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 1C4.1 1 1 4.1 1 8C1 11.9 4.1 15 8 15C11.9 15 15 11.9 15 8C15 4.1 11.9 1 8 1ZM8 14C4.7 14 2 11.3 2 8C2 4.7 4.7 2 8 2C11.3 2 14 4.7 14 8C14 11.3 11.3 14 8 14Z" fill="currentColor" />
                <path d="M10.7 11.5L8 8.8L5.3 11.5L4.5 10.7L7.2 8L4.5 5.3L5.3 4.5L8 7.2L10.7 4.5L11.5 5.3L8.8 8L11.5 10.7L10.7 11.5Z" fill="currentColor" />
            </svg>
        </button>
      `;
                imagePreview.appendChild(imageElement);

                const deleteButton = imageElement.querySelector('.delete-btn');
                deleteButton.addEventListener('click', function() {
                    // 削除ボタンがクリックされた時の処理
                    const imageContainer = this.parentNode;
                    const imageIndex = Array.from(imagePreview.children).indexOf(imageContainer);
                    imagePreview.removeChild(imageContainer);

                    // images[] 配列から対応する画像を削除する
                    if (imageIndex >= 0) {
                        files.splice(imageIndex, 1);
                    }
                });
            };
            reader.readAsDataURL(file);
        });
    });
</script>
