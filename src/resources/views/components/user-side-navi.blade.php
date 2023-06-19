<!--
    引数はアプリ内リンクとメインコンテンツ自体
        アプリ内リンクは表示名とリンク先のURL
        メインコンテンツはslotで渡す
            slotはタグ一つしか渡せないので、複数のタグを渡す場合は、divタグとかで囲って渡す
-->

<div x-data="setup()" @resize.window="watchScreen()">
    <div class="flex antialiased text-gray-900" style="height:calc(100vh - 64px);">
        <!-- Sidebar -->
        <div class="flex" :class=" (isSidebarOpen) ? 'w-52' : 'w-14'">
            <!-- Left mini bar -->
            <div class="text-left bg-white shadow-md" :class=" (isSidebarOpen) ? 'w-52' : 'w-14'">
                <!-- Menu button -->
                <button @click="(isSidebarOpen) ? isSidebarOpen = false : isSidebarOpen = true;" class="p-2 transition-colors rounded-lg hover:bg-gray-300 absolute top-3 left-3" :class=" (isSidebarOpen) ? 'text-gray-700' : 'text-gray-500 bg-white'">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.75 6.75H20.25M3.75 12H20.25M3.75 17.25H20.25" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <!-- Product -->
                <a href="{{ route('items.index')}}">
                    <div class="pt-5 text-blue-400" :class=" (isSidebarOpen) ? 'flex flex-row' : 'text-center'">
                        <div class="ml-4 text-center flex items-center">
                            <x-icon-pps></x-icon-pps>
                        </div>
                        <p x-show="!isSidebarOpen" class="font-patua text-xs">Product</p>
                        <p x-cloak x-show="isSidebarOpen" x-transition.duration.100ms class="font-patua ml-2 text-base">Peer Product
                            Share</p>
                    </div>
                </a>
                <!-- Event -->
                <a href="{{ route('events.index') }}">
                    <div href="#" class="text-pink-600" :class=" (isSidebarOpen) ? 'flex flex-row justify-start my-8' : 'text-center my-4'">
                        <div class="ml-4 text-center flex items-center" :class="{ '' : isSidebarOpen, 'mx-auto' : !isSidebarOpen}">
                            <x-icon-pe></x-icon-pe>
                        </div>
                        <p x-show="!isSidebarOpen" class="font-patua text-xs">Event</p>
                        <p x-cloak x-show="isSidebarOpen" x-transition.duration.100ms class="font-patua ml-2 text-base">Peer Event</p>
                    </div>
                </a>
                <!-- Request -->
                <a href="{{ route('requests.index') }}">
                    <div href="#" class="mb-4 text-peer-request" :class=" (isSidebarOpen) ? 'flex flex-row'
                        : 'text-center'">
                        <div class="ml-4 text-center flex items-center" :class="{ '' : isSidebarOpen, 'mx-auto' : !isSidebarOpen}">
                            <x-icon-pr></x-icon-pr>
                        </div>
                        <p x-show="!isSidebarOpen" class="font-patua text-xs">Request</p>
                        <p x-cloak x-show="isSidebarOpen" x-transition.duration.100ms class="font-patua ml-2 text-base">Peer Request</p>
                    </div>
                </a>
                <!-- アプリ内リンク -->
                <div x-show="isSidebarOpen">
                    <nav x-cloak x-show="isSidebarOpen" aria-label="Main" class="flex flex-col">
                        <hr class="border-gray-500 mx-4 mb-2">

                        <!-- urlが/eventsまたは/events/*の場合 -->
                        @if (request()->is('events') || request()->is('events/*'))
                        <a href="{{ route('mypage.events.joined') }}" class="mx-4 my-4 text-center flex items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 21C4.45 21 3.979 20.804 3.587 20.412C3.195 20.02 2.99934 19.5493 3 19V5C3 4.45 3.196 3.979 3.588 3.587C3.98 3.195 4.45067 2.99934 5 3H19C19.55 3 20.021 3.196 20.413 3.588C20.805 3.98 21.0007 4.45067 21 5V19C21 19.55 20.804 20.021 20.412 20.413C20.02 20.805 19.5493 21.0007 19 21H15V19H19V7H5V19H9V21H5ZM11 21V14.85L9.4 16.45L8 15L12 11L16 15L14.6 16.45L13 14.85V21H11Z" fill="black" />
                            </svg>
                            <p class="font-patua ml-2 p-1 text-sm">
                                参加イベント
                            </p>
                        </a>
                        <a href="{{ route('mypage.events.organized') }}" class="mx-4 text-center flex items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.7151 0.855469H4.28655C3.33978 0.855469 2.57227 1.62298 2.57227 2.56975V21.4269C2.57227 22.3737 3.33978 23.1412 4.28655 23.1412H19.7151C20.6619 23.1412 21.4294 22.3737 21.4294 21.4269V2.56975C21.4294 1.62298 20.6619 0.855469 19.7151 0.855469Z" stroke="black" stroke-width="1.71429" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M2.57227 17.9978H21.4294M7.71512 5.14062H16.2866M7.71512 9.42634H16.2866M7.71512 13.7121H12.858" stroke="black" stroke-width="1.71429" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="font-patua ml-2 p-1 text-sm">
                                主催イベント
                            </p>
                        </a>
                        @elseif(request()->is('items') || request()->is('items/*'))
                        <!-- urlが/itemsまたは/items/*の場合 -->
                        <a href="{{ route('mypage.items.listed') }}" class="mx-4 my-4 text-center flex items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.7151 0.855469H4.28655C3.33978 0.855469 2.57227 1.62298 2.57227 2.56975V21.4269C2.57227 22.3737 3.33978 23.1412 4.28655 23.1412H19.7151C20.6619 23.1412 21.4294 22.3737 21.4294 21.4269V2.56975C21.4294 1.62298 20.6619 0.855469 19.7151 0.855469Z" stroke="black" stroke-width="1.71429" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M2.57227 17.9978H21.4294M7.71512 5.14062H16.2866M7.71512 9.42634H16.2866M7.71512 13.7121H12.858" stroke="black" stroke-width="1.71429" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="font-patua ml-2 p-1 text-sm">
                                出品一覧
                            </p>
                        </a>
                        <!-- 取引履歴に飛ぶ -->
                        <a href="{{ route('mypage.items.history') }}" class="mx-4 my-4 text-center flex items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.5 12C4.5 16.142 7.858 19.5 12 19.5C16.142 19.5 19.5 16.142 19.5 12C19.5 7.85801 16.142 4.50001 12 4.50001C10.0458 4.49738 8.16819 5.26018 6.7695 6.62501H8.375C8.57391 6.62501 8.76468 6.70403 8.90533 6.84468C9.04598 6.98533 9.125 7.1761 9.125 7.37501C9.125 7.57392 9.04598 7.76469 8.90533 7.90534C8.76468 8.04599 8.57391 8.12501 8.375 8.12501H5.125C4.92609 8.12501 4.73532 8.04599 4.59467 7.90534C4.45402 7.76469 4.375 7.57392 4.375 7.37501V4.12501C4.375 3.9261 4.45402 3.73533 4.59467 3.59468C4.73532 3.45403 4.92609 3.37501 5.125 3.37501C5.32391 3.37501 5.51468 3.45403 5.65533 3.59468C5.79598 3.73533 5.875 3.9261 5.875 4.12501V5.40551C7.5381 3.85653 9.72728 2.99676 12 3.00001C16.9705 3.00001 21 7.02951 21 12C21 16.9705 16.9705 21 12 21C7.0295 21 3 16.9705 3 12C3 11.7395 3.011 11.481 3.033 11.226C3.0685 10.805 3.434 10.5 3.8565 10.5C4.2665 10.5 4.5725 10.8765 4.5335 11.285C4.5115 11.52 4.5 11.758 4.5 12ZM12.5 7.75001C12.5 7.5511 12.421 7.36033 12.2803 7.21968C12.1397 7.07903 11.9489 7.00001 11.75 7.00001C11.5511 7.00001 11.3603 7.07903 11.2197 7.21968C11.079 7.36033 11 7.5511 11 7.75001V12.75C11 12.9489 11.079 13.1397 11.2197 13.2803C11.3603 13.421 11.5511 13.5 11.75 13.5H14.25C14.4489 13.5 14.6397 13.421 14.7803 13.2803C14.921 13.1397 15 12.9489 15 12.75C15 12.5511 14.921 12.3603 14.7803 12.2197C14.6397 12.079 14.4489 12 14.25 12H12.5V7.75001Z" fill="black" />
                            </svg>
                            <p class="font-patua ml-2 p-1 text-sm">
                                取引履歴
                            </p>
                        </a>
                        <!-- urlが/requestsまたは/requests/*の場合 -->
                        @elseif(request()->is('requests') || request()->is('requests/*'))
                        <!-- ログインしているユーザーが投稿したリクエスト画面に飛ぶ -->
                        <a href="{{ route('mypage.requests.posted') }}" class="mx-4 my-4 text-center flex items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 21C4.45 21 3.979 20.804 3.587 20.412C3.195 20.02 2.99934 19.5493 3 19V5C3 4.45 3.196 3.979 3.588 3.587C3.98 3.195 4.45067 2.99934 5 3H19C19.55 3 20.021 3.196 20.413 3.588C20.805 3.98 21.0007 4.45067 21 5V19C21 19.55 20.804 20.021 20.412 20.413C20.02 20.805 19.5493 21.0007 19 21H15V19H19V7H5V19H9V21H5ZM11 21V14.85L9.4 16.45L8 15L12 11L16 15L14.6 16.45L13 14.85V21H11Z" fill="black" />
                            </svg>
                            <p class="font-patua ml-2 p-1 text-sm">
                                投稿したリクエスト
                            </p>
                        </a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
        <!-- Sidebar ここまで -->

        <!-- main content -->
        <main class="mx-auto w-full py-3 overflow-x-hidden overflow-y-auto">
            <div class="mx-4">
                @if (session('flush.message') && session('flush.alert_type') === 'info')
                <div class="flex rounded-md bg-blue-50 p-4 text-sm text-blue-500 mb-4" x-cloak x-show="showAlert" x-data="{ showAlert: true }">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-3 h-5 w-5 flex-shrink-0">
                        <path fill-rule="evenodd" d="M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0zM8.25 9.75A.75.75 0 019 9h.253a1.75 1.75 0 011.709 2.13l-.46 2.066a.25.25 0 00.245.304H11a.75.75 0 010 1.5h-.253a1.75 1.75 0 01-1.709-2.13l.46-2.066a.25.25 0 00-.245-.304H9a.75.75 0 01-.75-.75zM10 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    <div><b>Info:</b> {{ session('flush.message') }}</div>
                    <button class="ml-auto" x-on:click="showAlert = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
                @elseif (session('flush.message') && session('flush.alert_type') === 'success')
                <div class="flex rounded-md bg-green-50 p-4 text-sm text-green-500 mb-4" x-cloak x-show="showAlert" x-data="{ showAlert: true }">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-3 h-5 w-5 flex-shrink-0">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    <div><b>Success:</b> {{ session('flush.message') }}</div>
                    <button class="ml-auto" x-on:click="showAlert = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
                @elseif (session('flush.message') && session('flush.alert_type') === 'warning')
                <div class="flex rounded-md bg-yellow-50 p-4 text-sm text-yellow-500 mb-4" x-cloak x-show="showAlert" x-data="{ showAlert: true }">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-3 h-5 w-5 flex-shrink-0">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    <div><b>Warning:</b> {{ session('flush.message') }}</div>
                    <button class="ml-auto" x-on:click="showAlert = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
                @elseif (session('flush.message') && session('flush.alert_type') === 'error')
                <div class="flex rounded-md bg-red-50 p-4 text-sm text-red-500 mb-4" x-cloak x-show="showAlert" x-data="{ showAlert: true }">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-3 h-5 w-5 flex-shrink-0">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                    <div><b>エラー:</b> {{ session('flush.message') }}</div>
                    <button class="ml-auto" x-on:click="showAlert = false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
                @endif
            </div>
            {{ $slot }}
        </main>
    </div>
</div>

<!-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script> -->
<script>
    const setup = () => {
        return {
            isSidebarOpen: false,
            currentSidebarTab: null,
            isSettingsPanelOpen: false,
            isSubHeaderOpen: false,
            watchScreen() {
                if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false
                }
            },
        }
    }
</script>
