<x-admin-app>
    <x-slot name="title">
        {{ __('ユーザ一覧') }}
    </x-slot>
    <x-slot name="description">
        {{ __('PeerPerkに登録されているユーザの一覧が表示されます。また、slackワークスペースに所属しているユーザをPeerPerkユーザに登録することもできます。') }}
    </x-slot>

    <div class="bg-white shadow rounded-lg md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100 flex justify-between">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 0}">
                            PeerPerk登録ユーザ一覧
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $users->total() }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 1}">
                            PeerPerk未登録ユーザ一覧
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                ??
                            </span>
                        </a>
                    </li>
                </ul>
                <div>
                    <a class="rounded-lg border border-blue-500 bg-blue-500 px-4 py-2 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-blue-700 hover:bg-blue-700 focus:ring focus:ring-blue-200 disabled:cursor-not-allowed disabled:border-blue-300 disabled:bg-blue-300">
                        slackユーザ取得
                    </a>
                </div>
            </div>
            <div class="py-3">
                <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 ">
                            <thead class="bg-gray-50 whitespace-nowrap">
                                <tr>
                                    <th scope="col" class="px-4 py-4 font-medium text-gray-900"></th>
                                    <th scope="col" class="px-4 py-4 font-medium text-gray-900">氏名</th>
                                    <th scope="col" class="px-4 py-4 font-medium text-gray-900">メールアドレス</th>
                                    <th scope="col" class="px-4 py-4 font-medium text-gray-900">所属部署</th>
                                    <th scope="col" class="px-4 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <th class="flex gap-3 px-4 py-4 font-normal text-gray-900">
                                        <div class="relative h-10 w-10">
                                            <img class="h-full w-full rounded-full object-cover object-center" src="{{ $user -> icon }}" alt="ユーザアイコン" />
                                            {!! $user -> is_admin === 0
                                            ? '<span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>'
                                            : '<span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-pink-400 ring ring-white"></span>'
                                            !!}
                                        </div>
                                    </th>
                                    <td class="px-4 py-4">{{ $user -> name }}</td>
                                    <td class="px-4 py-4">{{ $user -> email }}</td>
                                    <td class="px-4 py-4">{{ $user -> department ? $user -> department -> name : '' }}</td>
                                    <td class="px-4 py-4">
                                        <div class="flex justify-between gap-2 text-left whitespace-nowrap">
                                            <x-admin-button-detail href="{{ route('admin.users.show', ['user' =>  $user -> id]) }}"></x-admin-button-detail>
                                            <x-admin-button-edit action="{{ route('admin.users.update', ['user' =>  $user -> id]) }}">
                                                @if ($user -> is_admin === 0)
                                                <x-slot name="content">
                                                    管理者権限を付与
                                                </x-slot>
                                                <x-slot name="modal_title">
                                                    {{ $user -> name }}を管理者に変更しますか？
                                                </x-slot>
                                                <x-slot name="modal_description">
                                                    対象のユーザをPeerPerkの管理者に変更します。管理者に変更されたユーザは、slackの管理者チャンネルに追加されます。
                                                </x-slot>
                                                @elseif ($user -> is_admin === 1)
                                                <x-slot name="content">
                                                    一般ユーザに変更
                                                </x-slot>
                                                <x-slot name="modal_title">
                                                    {{ $user -> name }}を一般ユーザに変更しますか？
                                                </x-slot>
                                                <x-slot name="modal_description">
                                                    対象のユーザをPeerPerkの一般ユーザに変更します。一般ユーザに変更されたユーザは、slackの管理者チャンネルから削除されます。
                                                </x-slot>
                                                @endif
                                                <x-slot name="method">
                                                    @method('PUT')
                                                </x-slot>
                                                <x-slot name="form_slot"></x-slot>
                                            </x-admin-button-edit>
                                            <x-admin-button-delete action="{{ route('admin.users.destroy', ['user' =>  $user -> id]) }}">
                                                <x-slot name="modal_title">
                                                    {{ $user -> name }}を削除しますか？
                                                </x-slot>
                                                <x-slot name="modal_description">
                                                    対象のユーザをPeerPerkのユーザから削除します。ここで削除されたユーザはslackに所属している限り、再度登録することができます。
                                                </x-slot>
                                            </x-admin-button-delete>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $users->withPath(url('/admin/users'))->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-app>
