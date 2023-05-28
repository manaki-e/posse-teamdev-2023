<?php


use Illuminate\Support\Facades\Auth;

//userのログイン情報を$user_infoに格納
$user_info = Auth::user();

?>

<div x-data="{ modelOpen: false }">
    <div @click="modelOpen =!modelOpen" class="rounded-lg w-40 mx-3 my-1 px-7 py-2 shadow-md text-center text-sm text-white admin-bg-green border admin-border-green transition-all hover:shadow-lg hover:opacity-75 ">
        <a href="#" class="">
            ポイント交換
        </a>
    </div>
    <!-- モーダル中身 -->
    <div x-cloak x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
            <div x-cloak @click="modelOpen = false" x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

            <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-xl p-8 my-40 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                <div class="flex items-center justify-between space-x-4">
                    <h1 class="text-xl font-semibold text-gray-800 pl-2 border-l-4 admin-border-green">ポイントの換金申請</h1>
                    <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
                <p class="mt-2 text-gray-500 ">
                    Bouns PointをAmazonギフト券に 500pt 単位で換金できます<br>
                    現在のBouns Point {{$user_info->earned_point}} pt
                </p>
                <form action="{{route('point-exchange.store')}}" method="POST" class="mt-5">
                    @csrf
                    @if($user_info->earned_point >= 500)
                    <div>
                        <label class="block text-sm text-gray-700 capitalize dark:text-gray-200">Bouns Point</label>
                        <select name="point" list="point_list" step="500" type="number" step="500" min="0" max="{{ 500 * floor($user_info->earned_point / 500) }}" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md" required>
                            @for ($i = 1; $i <= floor($user_info->earned_point / 500); $i++)
                                <option value="{{ $i * 500 }}">{{ $i * 500 }}</option>
                                @endfor
                        </select>
                        <p class="ml-2 text-sm text-gray-500">
                            {{ 500 * floor($user_info->earned_point / 500) }} pt まで換金できます
                        </p>
                    </div>
                    @endif
                    <div class="mt-6">
                        @if($user_info->earned_point < 500)
                        <div>
                            <div class="block w-full rounded-lg my-1 py-3 font-bold text-center text-sm transition-all align-middle text-red-400">
                                Bouns Pointが不足しています
                            </div>
                        </div>
                        @else
                        <x-user-register-button textColor="text-white" bgColor="admin-bg-green" borderColor="admin-border-green">
                            <x-slot name="button">換金申請する</x-slot>
                        </x-user-register-button>
                        @endif
                        <div @click="modelOpen = false">
                            <div class="block cursor-pointer w-full rounded-lg my-1 py-3 font-bold text-center text-sm transition-all align-middle admin-text-green hover:bg-gray-50">
                                キャンセル
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
