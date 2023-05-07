<x-admin-app>
    <x-slot name="title">
        {{ __('ユーザ一覧') }}
    </x-slot>
    <x-slot name="discription">
        {{ __('APのslackワークスペースに所属しており、メールアドレスが@anti-pattern.co.jpであるユーザの一覧が表示されます') }}
    </x-slot>

    <div class="bg-white shadow rounded-lg md:p-6 w-full">
        <div x-data="{ activeTab: {{ request()->query('activeTab', 0) }} }">
            <div class="border-b border-b-gray-100">
                <ul class="-mb-px flex items-center gap-4 text-sm font-medium">
                    <li>
                        <a @click="activeTab = 0" class="inline-flex cursor-pointer items-center gap-2 px-1 py-3 text-blue-500 hover:text-blue-500" :class="{'relative text-blue-500  after:absolute after:left-0 after:bottom-0 after:h-0.5 after:w-full after:bg-blue-500': activeTab === 0}">
                            ユーザ一覧
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-500">
                                {{ $users->total() }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="py-3">
                <div :class="{ '!block': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0" class="hidden">
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-4">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 ">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">氏名</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">メールアドレス</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900">所属部署</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">獲得 pt</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 text-right">利用 pt</th>
                                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
                                        <div class="relative h-10 w-10">
                                            <img class="h-full w-full rounded-full object-cover object-center" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                            {!! $user -> is_admin === 0
                                            ? '<span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>'
                                            : '<span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-pink-400 ring ring-white"></span>'
                                            !!}
                                        </div>
                                        <div class="text-sm flex-center">
                                            <div class="font-medium text-gray-700">{{ $user -> name }}</div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">{{ $user -> email }}</td>
                                    <td class="px-6 py-4">{{ $user -> department -> name }}</td>
                                    <td class="px-6 py-4 text-right">{{ $user -> earned_point }} pt</td>
                                    <td class="px-6 py-4 text-right">{{ $user -> distribution_point }} pt</td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-4">
                                            <x-admin-button-detail href="/admin/users/{{ $user -> id }}"></x-admin-button-detail>
                                            <x-admin-button-delete action="/admin/users/{{ $user -> id }}"></x-admin-button-delete>
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
