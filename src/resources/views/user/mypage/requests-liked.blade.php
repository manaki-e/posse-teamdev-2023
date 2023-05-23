<x-mypage-app>
    <x-slot:title>投稿したリクエスト一覧</x-slot:title>
    <x-slot:earned_point>580</x-slot:earned_point>
    <x-slot:distribution_point>5000</x-slot:distribution_point>

    <div class="bg-white md:p-6 w-full">
        <div>
            <div>
                <ul class="border-b border-gray-300">
                    @foreach ($liked_requests as $request)
                    <li>
                        <x-mypage-request-list>
                            <x-slot:title>{{ $request -> title }}</x-slot:title>
                            <x-slot:description>{{ $request -> description }}</x-slot:description>
                            <x-slot:likes></x-slot:likes>
                            <x-slot:tag>
                                @foreach ($request->requestTags as $tag)
                                <x-user-tag>{{ $tag->tag->name }}</x-user-tag>
                                @endforeach
                            </x-slot:tag>
                            <x-slot:button>
                                <x-mypage-button-edit href="{{ route('items.edit', ['item' =>  $request -> id]) }}"></x-mypage-button-edit>
                                <x-mypage-button-delete action="{{ route('items.destroy', ['item' =>  $request -> id]) }}">
                                    <x-slot name="modal_title">
                                        {{ $request -> title }}を削除しますか？
                                    </x-slot>
                                    <x-slot name="modal_description">
                                        対象のリクエストを削除します。一度削除すると復元できません。
                                    </x-slot>
                                </x-mypage-button-delete>
                            </x-slot:button>
                        </x-mypage-request-list>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-mypage-app>
