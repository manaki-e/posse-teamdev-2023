<?php


use Illuminate\Support\Facades\Auth;

//userのログイン情報を$user_infoに格納
$user_info = Auth::user();

?>
<!--
    引数は色、アプリ名、ボタン名、各ポイント、ユーザーのアイコン、アカウントページ、マイページへのリンク
    textColorとbgColorには以下の色を指定する
        Product Share : text-blue-400 / bg-blue-400
        Event : text-pink-600 / bg-pink-600
        Request : text-peer-request / bg-peer-request
-->
<header class="text-gray-600 body-font">
    <div class="mx-3 flex justify-between p-2 flex-col md:flex-row items-center">
        <div {{ $attributes->merge(['class' => 'flex '.$textColor]) }}>
            <a href="{{ $top_title_link }}" class="flex title-font font-medium items-center ml-10 mb-4 md:mb-0">
                @if (request()->is('items') || request()->is('items/*'))
                <x-icon-pps></x-icon-pps>
                @elseif(request()->is('mypage') || request()->is('mypage/*'))
                <x-application-logo></x-application-logo>
                @elseif (request()->is('events') || request()->is('events/*'))
                <x-icon-pe></x-icon-pe>
                @elseif (request()->is('requests') || request()->is('requests/*'))
                <x-icon-pr></x-icon-pr>
                @endif
                <span class="ml-3 text-xl font-patua">{{ $app_name }}</span>
            </a>
        </div>
        <div class="flex max-w-full">
            @if(Auth::user()->is_admin == 1)
            <a href="{{ route('admin.items.index') }}" class="rounded-lg w-40 mx-3 my-1 px-7 py-2 shadow-md text-center text-sm admin-text-green border
            admin-border-green transition-all hover:shadow-lg hover:opacity-75 ">
                管理者画面へ
            </a>
            @endif
            @if(request()->is('mypage') || request()->is('mypage/*'))
            <x-point-exchange></x-point-exchange>
            @else
            <a href="{{ $button_link }}" {{ $button_text ?? 'hidden'  }} {{ $attributes->merge(['class' => 'rounded-lg w-40 mx-3 my-1 px-7 py-2 shadow-md text-center text-sm text-white transition-all hover:shadow-lg hover:opacity-75 '.$bgColor]) }}>
                {{ $button_text ?? '' }}
            </a>
            @endif
            <div x-data=" { tooltip: false }" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" class="w-24 h-12 mx-2 cursor-pointer relative">
                <div class="flex justify-between items-center">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 8C2 8.78793 2.15519 9.56815 2.45672 10.2961C2.75825 11.0241 3.20021 11.6855 3.75736 12.2426C4.31451 12.7998 4.97595 13.2417 5.7039 13.5433C6.43185 13.8448 7.21207 14 8 14C8.78793 14 9.56815 13.8448 10.2961 13.5433C11.0241 13.2417 11.6855 12.7998 12.2426 12.2426C12.7998 11.6855 13.2417 11.0241 13.5433 10.2961C13.8448 9.56815 14 8.78793 14 8C14 7.21207 13.8448 6.43185 13.5433 5.7039C13.2417 4.97595 12.7998 4.31451 12.2426 3.75736C11.6855 3.20021 11.0241 2.75825 10.2961 2.45672C9.56815 2.15519 8.78793 2 8 2C7.21207 2 6.43185 2.15519 5.7039 2.45672C4.97595 2.75825 4.31451 3.20021 3.75736 3.75736C3.20021 4.31451 2.75825 4.97595 2.45672 5.7039C2.15519 6.43185 2 7.21207 2 8Z" stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M6.66602 10.6654V5.33203H8.33268C8.77471 5.33203 9.19863 5.50763 9.51119 5.82019C9.82375 6.13275 9.99935 6.55667 9.99935 6.9987C9.99935 7.44073 9.82375 7.86465 9.51119 8.17721C9.19863 8.48977 8.77471 8.66536 8.33268 8.66536H6.66602" stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="text-black">{{ $user_info->earned_point }} pt</p>
                </div>
                <hr class="border-black">
                <div class="flex justify-between items-center">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 8C2 8.78793 2.15519 9.56815 2.45672 10.2961C2.75825 11.0241 3.20021 11.6855 3.75736 12.2426C4.31451 12.7998 4.97595 13.2417 5.7039 13.5433C6.43185 13.8448 7.21207 14 8 14C8.78793 14 9.56815 13.8448 10.2961 13.5433C11.0241 13.2417 11.6855 12.7998 12.2426 12.2426C12.7998 11.6855 13.2417 11.0241 13.5433 10.2961C13.8448 9.56815 14 8.78793 14 8C14 7.21207 13.8448 6.43185 13.5433 5.7039C13.2417 4.97595 12.7998 4.31451 12.2426 3.75736C11.6855 3.20021 11.0241 2.75825 10.2961 2.45672C9.56815 2.15519 8.78793 2 8 2C7.21207 2 6.43185 2.15519 5.7039 2.45672C4.97595 2.75825 4.31451 3.20021 3.75736 3.75736C3.20021 4.31451 2.75825 4.97595 2.45672 5.7039C2.15519 6.43185 2 7.21207 2 8Z" stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7.99935 7.9987C8.35297 7.9987 8.69211 8.13917 8.94216 8.38922C9.19221 8.63927 9.33268 8.97841 9.33268 9.33203C9.33268 9.68565 9.19221 10.0248 8.94216 10.2748C8.69211 10.5249 8.35297 10.6654 7.99935 10.6654H6.66602V5.33203H7.99935C8.35297 5.33203 8.69211 5.47251 8.94216 5.72256C9.19221 5.9726 9.33268 6.31174 9.33268 6.66536C9.33268 7.01899 9.19221 7.35812 8.94216 7.60817C8.69211 7.85822 8.35297 7.9987 7.99935 7.9987ZM7.99935 7.9987H6.66602" stroke="black" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="text-black">{{ $user_info->distribution_point }} pt</p>
                </div>

                <div x-cloak x-show.transition.origin.top="tooltip" x-transition.duration.400ms class="absolute w-32 top-14 z-10 p-2 text-sm leading-tight text-white bg-black bg-opacity-75 rounded-lg shadow-lg">
                    <div class="flex justify-evenly items-center text-white">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 8C2 8.78793 2.15519 9.56815 2.45672 10.2961C2.75825 11.0241 3.20021 11.6855 3.75736 12.2426C4.31451 12.7998 4.97595 13.2417 5.7039 13.5433C6.43185 13.8448 7.21207 14 8 14C8.78793 14 9.56815 13.8448 10.2961 13.5433C11.0241 13.2417 11.6855 12.7998 12.2426 12.2426C12.7998 11.6855 13.2417 11.0241 13.5433 10.2961C13.8448 9.56815 14 8.78793 14 8C14 7.21207 13.8448 6.43185 13.5433 5.7039C13.2417 4.97595 12.7998 4.31451 12.2426 3.75736C11.6855 3.20021 11.0241 2.75825 10.2961 2.45672C9.56815 2.15519 8.78793 2 8 2C7.21207 2 6.43185 2.15519 5.7039 2.45672C4.97595 2.75825 4.31451 3.20021 3.75736 3.75736C3.20021 4.31451 2.75825 4.97595 2.45672 5.7039C2.15519 6.43185 2 7.21207 2 8Z" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6.66602 10.6654V5.33203H8.33268C8.77471 5.33203 9.19863 5.50763 9.51119 5.82019C9.82375 6.13275 9.99935 6.55667 9.99935 6.9987C9.99935 7.44073 9.82375 7.86465 9.51119 8.17721C9.19863 8.48977 8.77471 8.66536 8.33268 8.66536H6.66602" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="text-xs">換金ポイント</p>
                    </div>
                    <div class="flex justify-evenly items-center text-white">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 8C2 8.78793 2.15519 9.56815 2.45672 10.2961C2.75825 11.0241 3.20021 11.6855 3.75736 12.2426C4.31451 12.7998 4.97595 13.2417 5.7039 13.5433C6.43185 13.8448 7.21207 14 8 14C8.78793 14 9.56815 13.8448 10.2961 13.5433C11.0241 13.2417 11.6855 12.7998 12.2426 12.2426C12.7998 11.6855 13.2417 11.0241 13.5433 10.2961C13.8448 9.56815 14 8.78793 14 8C14 7.21207 13.8448 6.43185 13.5433 5.7039C13.2417 4.97595 12.7998 4.31451 12.2426 3.75736C11.6855 3.20021 11.0241 2.75825 10.2961 2.45672C9.56815 2.15519 8.78793 2 8 2C7.21207 2 6.43185 2.15519 5.7039 2.45672C4.97595 2.75825 4.31451 3.20021 3.75736 3.75736C3.20021 4.31451 2.75825 4.97595 2.45672 5.7039C2.15519 6.43185 2 7.21207 2 8Z" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7.99935 7.9987C8.35297 7.9987 8.69211 8.13917 8.94216 8.38922C9.19221 8.63927 9.33268 8.97841 9.33268 9.33203C9.33268 9.68565 9.19221 10.0248 8.94216 10.2748C8.69211 10.5249 8.35297 10.6654 7.99935 10.6654H6.66602V5.33203H7.99935C8.35297 5.33203 8.69211 5.47251 8.94216 5.72256C9.19221 5.9726 9.33268 6.31174 9.33268 6.66536C9.33268 7.01899 9.19221 7.35812 8.94216 7.60817C8.69211 7.85822 8.35297 7.9987 7.99935 7.9987ZM7.99935 7.9987H6.66602" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="text-xs">利用ポイント</p>
                    </div>
                </div>
            </div>
            <!-- component -->
            <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
            <div class="z-50 flex justify-center items-center">
                <div x-data="{ open: false }" class="flex justify-center items-center">
                    <div @click="open = !open" class="relative w-12 h-12 cursor-pointer flex justify-center items-center" :class="{'transform transition duration-300 ': open}" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100">
                        <!-- icon -->
                        <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-gray-900">
                            <img src="{{ Auth::user()->icon }}" alt="" class="w-8 h-8 object-cover">
                        </div>
                        <!-- pannel -->
                        <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 top-full w-48 bg-white rounded-lg shadow border mt-5">
                            <ul>
                                <li class="px-5 py-3 font-medium hover:bg-gray-100">
                                    <!-- プロフィールに移行する -->
                                    <a href="#" class="flex items-center transform transition-colors duration-200">
                                        <div class="mr-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                        プロフィール
                                    </a>
                                </li>
                                <li class="px-5 py-3 font-medium hover:bg-gray-100">
                                    <a href="#" class="flex items-center transform transition-colors duration-200">
                                        <div class="mr-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        アカウント
                                    </a>
                                </li>
                                <hr>
                                <li class="px-5 py-3 font-medium hover:bg-gray-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <div class="flex items-center transform transition-colors duration-200" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                            <div class="mr-3 text-red-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                    </path>
                                                </svg>
                                            </div>
                                            ログアウト
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
