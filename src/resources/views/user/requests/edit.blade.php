<x-user-app>
    <x-slot name="header_slot">
        <x-user-header textColor="text-peer-request" bgColor="bg-peer-request">
            <x-slot:app_name>Peer Request</x-slot:app_name>
            <x-slot:button_text>リクエスト登録</x-slot:button_text>
            <x-slot:button_link>{{ route('requests.create') }}</x-slot:button_link>
            <x-slot:earned_point>{{ Auth::user()->earned_point }}</x-slot:earned_point>
            <x-slot:distribution_point>{{ Auth::user()->distribution_point }}</x-slot:distribution_point>
            <x-slot:top_title_link>{{ route('requests.index') }}</x-slot:top_title_link>
        </x-user-header>
    </x-slot>
    <x-slot name="body_slot">
        <x-user-side-navi>
            <div class="w-full mx-auto">
                <x-user-form method="POST" action="{{ route('requests.update',$request->id) }}">
                    @method('PUT')
                    <x-slot name="title">リクエストの編集</x-slot>
                    <section class="text-left w-full flex gap-8">
                        <section class="my-6 w-1/2">
                            <h3 class="mb-2 text-xl text-gray-600 font-extrabold border-b border-gray-500">タイトルと概要</h3>
                            <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">タイトル<span class="text-red-600">*</span></h4>
                            <div class="mx-auto">
                                <input value="{{ $request->title }}" name="title" type="text" class="p-1 block w-full rounded-md border border-gray-300" required />
                            </div>
                            <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">リクエストの概要<span class="text-red-600">*</span></h4>
                            <div class="mx-auto">
                                <textarea name="description" class="p-1 block w-full rounded-md border border-gray-300" rows="3" required>{{ $request->description }}</textarea>
                            </div>
                        </section>
                        <section class="my-6 w-1/2">
                            <h3 class="mb-2 text-xl text-gray-600 font-extrabold border-b border-gray-500">リクエストの詳細</h3>
                            <h4 class="mb-1 mt-4 block text-sm font-medium text-gray-700">区分<span class="text-red-600">*</span></h4>
                            <div class="tab-wrapper" x-data="{ activeTab:  @if($request->type_id==$product_request_type_id) 0 @else 1 @endif  }">
                                <div class="text-base">
                                    <div class="mx-1 grid sm:grid-cols-2 gap-2">
                                        <label for="product" class="flex p-3 w-full bg-white border border-gray-300 rounded-md text-sm" @click="activeTab = 0">
                                            <input type="radio" name="type_id" value="{{ $product_request_type_id }}" class="shrink-0 mt-0.5 border-gray-200 rounded-full" id="product" @if($request->type_id==$product_request_type_id) checked @endif>
                                            <span class="text-sm ml-3">アイテム</span>
                                        </label>
                                        <label for="event" class="flex p-3 w-full bg-white border border-gray-300 rounded-md text-sm" @click="activeTab = 1">
                                            <input type="radio" name="type_id" value="{{ $event_request_type_id }}" class="shrink-0 mt-0.5 border-gray-200 rounded-full" id="event" @if($request->type_id==$event_request_type_id) checked @endif>
                                            <span class="text-sm ml-3">イベント</span>
                                        </label>
                                    </div>
                                </div>

                                <h4 class=" mb-1 mt-4 block text-sm font-medium text-gray-700">カテゴリ</h4>
                                <div @if($request->type_id!=$product_request_type_id) x-cloak @endif class="w-full flex flex-wrap max-w-lg text-sm font-medium text-gray-900 bg-white" x-show="activeTab === 0">
                                    @foreach ($product_tags as $index => $product_tag)
                                    <div class="min-w-max m-1 border rounded border-gray-200">
                                        <div class="flex items-center px-3">
                                            <input name="product_tags[]" id="product_tag_{{ $product_tag->id }}" type="checkbox" value="{{ $product_tag->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" @if($product_tag->checked) checked @endif>
                                            <label for="product_tag_{{ $product_tag->id }}" class="w-auto py-3 pl-1 text-sm font-medium text-gray-900">{{ $product_tag->name }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div @if($request->type_id!=$event_request_type_id) x-cloak @endif class="w-full flex flex-wrap max-w-lg text-sm font-medium text-gray-900 bg-white" x-show="activeTab === 1">
                                    @foreach ($event_tags as $index => $event_tag)
                                    <div class="min-w-max m-1 border rounded border-gray-200">
                                        <div class="flex items-center px-3">
                                            <input name="event_tags[]" id="event_tag_{{ $event_tag->id }}" type="checkbox" value="{{ $event_tag->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" @if($event_tag->checked) checked @endif>
                                            <label for="event_tag_{{ $event_tag->id }}" class="w-auto py-3 pl-1 text-sm font-medium text-gray-900">{{ $event_tag->name }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    </section>
                    <x-user-register-button textColor="text-white" bgColor="bg-peer-request" borderColor="border-peer-request">
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
    [x-cloak] {
        display: none;
    }
</style>
