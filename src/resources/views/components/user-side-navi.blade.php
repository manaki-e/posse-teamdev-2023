<!--
    引数はアプリ内リンクとメインコンテンツ自体
        アプリ内リンクは表示名とリンク先のURL
        メインコンテンツはslotで渡す
            slotはタグ一つしか渡せないので、複数のタグを渡す場合は、divタグとかで囲って渡す
-->

<div x-data="setup()" @resize.window="watchScreen()">
    <div class="flex antialiased text-gray-900" style="height:calc(100vh - 64px);">
        <!-- Sidebar -->
        <div class="flex" :class=" (isSidebarOpen) ? 'w-48' : 'w-14'">
            <!-- Left mini bar -->
            <div class="text-left bg-white shadow-md" :class=" (isSidebarOpen) ? 'w-48' : 'w-14'">
                <!-- Menu button -->
                <button @click="(isSidebarOpen) ? isSidebarOpen = false : isSidebarOpen = true;" class="p-2 transition-colors rounded-lg hover:bg-gray-300 absolute top-3 left-3" :class=" (isSidebarOpen) ? 'text-gray-700' : 'text-gray-500 bg-white'">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.75 6.75H20.25M3.75 12H20.25M3.75 17.25H20.25" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <!-- Product -->
                <a href="#">
                    <div class="pt-5 text-blue-400" :class=" (isSidebarOpen) ? 'flex flex-row' : 'text-center'">
                        <div class="ml-4 text-center flex items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="stroke-current">
                                <path d="M3 12C3 13.1819 3.23279 14.3522 3.68508 15.4442C4.13738 16.5361 4.80031 17.5282 5.63604 18.364C6.47177 19.1997 7.46392 19.8626 8.55585 20.3149C9.64778 20.7672 10.8181 21 12 21C13.1819 21 14.3522 20.7672 15.4442 20.3149C16.5361 19.8626 17.5282 19.1997 18.364 18.364C19.1997 17.5282 19.8626 16.5361 20.3149 15.4442C20.7672 14.3522 21 13.1819 21 12C21 10.8181 20.7672 9.64778 20.3149 8.55585C19.8626 7.46392 19.1997 6.47177 18.364 5.63604C17.5282 4.80031 16.5361 4.13738 15.4442 3.68508C14.3522 3.23279 13.1819 3 12 3C10.8181 3 9.64778 3.23279 8.55585 3.68508C7.46392 4.13738 6.47177 4.80031 5.63604 5.63604C4.80031 6.47177 4.13738 7.46392 3.68508 8.55585C3.23279 9.64778 3 10.8181 3 12Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M10 16V8H12.5C13.163 8 13.7989 8.26339 14.2678 8.73223C14.7366 9.20107 15 9.83696 15 10.5C15 11.163 14.7366 11.7989 14.2678 12.2678C13.7989 12.7366 13.163 13 12.5 13H10" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <p class="font-patua" :class=" (isSidebarOpen) ? 'hidden': 'text-xs'">Product</p>
                        <p class="font-patua p-1 rounded hover:bg-gray-100" :class="{ 'hidden' : ! isSidebarOpen, 'ml-2 text-base' : isSidebarOpen}">Peer Product
                            Share</p>
                    </div>
                </a>
                <!-- Event -->
                <a href="#">
                    <div href="#" class="text-pink-600" :class=" (isSidebarOpen) ? 'flex flex-row justify-start my-8' : 'text-center my-4'">
                        <div class="ml-4 text-center flex items-center" :class="{ '' : isSidebarOpen, 'mx-auto' : !isSidebarOpen}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="stroke-current">
                                <path d="M3 12C3 13.1819 3.23279 14.3522 3.68508 15.4442C4.13738 16.5361 4.80031 17.5282 5.63604 18.364C6.47177 19.1997 7.46392 19.8626 8.55585 20.3149C9.64778 20.7672 10.8181 21 12 21C13.1819 21 14.3522 20.7672 15.4442 20.3149C16.5361 19.8626 17.5282 19.1997 18.364 18.364C19.1997 17.5282 19.8626 16.5361 20.3149 15.4442C20.7672 14.3522 21 13.1819 21 12C21 10.8181 20.7672 9.64778 20.3149 8.55585C19.8626 7.46392 19.1997 6.47177 18.364 5.63604C17.5282 4.80031 16.5361 4.13738 15.4442 3.68508C14.3522 3.23279 13.1819 3 12 3C10.8181 3 9.64778 3.23279 8.55585 3.68508C7.46392 4.13738 6.47177 4.80031 5.63604 5.63604C4.80031 6.47177 4.13738 7.46392 3.68508 8.55585C3.23279 9.64778 3 10.8181 3 12Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M10 16V8H12.5C13.163 8 13.7989 8.26339 14.2678 8.73223C14.7366 9.20107 15 9.83696 15 10.5C15 11.163 14.7366 11.7989 14.2678 12.2678C13.7989 12.7366 13.163 13 12.5 13H10" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <p class="font-patua" :class=" (isSidebarOpen) ? 'hidden': 'text-xs'">Event</p>
                        <p class="font-patua p-1 rounded hover:bg-gray-100" :class="{'ml-2 text-base' : isSidebarOpen, 'hidden' : ! isSidebarOpen}">Peer Event</p>
                    </div>
                </a>
                <!-- Request -->
                <a href="#">
                    <div href="#" class="mb-4 text-peer-request" :class=" (isSidebarOpen) ? 'flex flex-row'
                        : 'text-center'">
                        <div class="ml-4 text-center flex items-center" :class="{ '' : isSidebarOpen, 'mx-auto' : !isSidebarOpen}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="stroke-current">
                                <path d="M3 12C3 13.1819 3.23279 14.3522 3.68508 15.4442C4.13738 16.5361 4.80031 17.5282 5.63604 18.364C6.47177 19.1997 7.46392 19.8626 8.55585 20.3149C9.64778 20.7672 10.8181 21 12 21C13.1819 21 14.3522 20.7672 15.4442 20.3149C16.5361 19.8626 17.5282 19.1997 18.364 18.364C19.1997 17.5282 19.8626 16.5361 20.3149 15.4442C20.7672 14.3522 21 13.1819 21 12C21 10.8181 20.7672 9.64778 20.3149 8.55585C19.8626 7.46392 19.1997 6.47177 18.364 5.63604C17.5282 4.80031 16.5361 4.13738 15.4442 3.68508C14.3522 3.23279 13.1819 3 12 3C10.8181 3 9.64778 3.23279 8.55585 3.68508C7.46392 4.13738 6.47177 4.80031 5.63604 5.63604C4.80031 6.47177 4.13738 7.46392 3.68508 8.55585C3.23279 9.64778 3 10.8181 3 12Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M10 16V8H12.5C13.163 8 13.7989 8.26339 14.2678 8.73223C14.7366 9.20107 15 9.83696 15 10.5C15 11.163 14.7366 11.7989 14.2678 12.2678C13.7989 12.7366 13.163 13 12.5 13H10" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <p class="font-patua" :class=" (isSidebarOpen) ? 'hidden': 'text-xs'">Request</p>
                        <p class="font-patua p-1 rounded hover:bg-gray-100" :class="{ 'hidden' : ! isSidebarOpen, 'ml-2 text-base' : isSidebarOpen}">Peer Request</p>
                    </div>
                </a>
                <!-- アプリ内リンク -->
                <div x-show="isSidebarOpen">
                    <nav x-show="isSidebarOpen" aria-label="Main" class="flex flex-col">
                        <hr class="border-gray-500 mx-4">
                        <a href="#" class="mx-4 my-4 text-center flex items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 21C4.45 21 3.979 20.804 3.587 20.412C3.195 20.02 2.99934 19.5493 3 19V5C3 4.45 3.196 3.979 3.588 3.587C3.98 3.195 4.45067 2.99934 5 3H19C19.55 3 20.021 3.196 20.413 3.588C20.805 3.98 21.0007 4.45067 21 5V19C21 19.55 20.804 20.021 20.412 20.413C20.02 20.805 19.5493 21.0007 19 21H15V19H19V7H5V19H9V21H5ZM11 21V14.85L9.4 16.45L8 15L12 11L16 15L14.6 16.45L13 14.85V21H11Z" fill="black" />
                            </svg>
                            <p class="font-patua ml-2 p-1 text-base rounded hover:bg-gray-100">
                                参加イベント
                            </p>
                        </a href="#">
                        <a href="#" class="mx-4 text-center flex items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.7151 0.855469H4.28655C3.33978 0.855469 2.57227 1.62298 2.57227 2.56975V21.4269C2.57227 22.3737 3.33978 23.1412 4.28655 23.1412H19.7151C20.6619 23.1412 21.4294 22.3737 21.4294 21.4269V2.56975C21.4294 1.62298 20.6619 0.855469 19.7151 0.855469Z" stroke="black" stroke-width="1.71429" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M2.57227 17.9978H21.4294M7.71512 5.14062H16.2866M7.71512 9.42634H16.2866M7.71512 13.7121H12.858" stroke="black" stroke-width="1.71429" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="font-patua ml-2 p-1 text-base rounded hover:bg-gray-100">
                                主催イベント
                            </p>
                        </a href="#">
                        <a href="#" class="mx-4 my-4 text-center flex items-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 9V21H1V9H5ZM9 21C8.46957 21 7.96086 20.7893 7.58579 20.4142C7.21071 20.0391 7 19.5304 7 19V9C7 8.45 7.22 7.95 7.59 7.59L14.17 1L15.23 2.06C15.5 2.33 15.67 2.7 15.67 3.11L15.64 3.43L14.69 8H21C21.5304 8 22.0391 8.21071 22.4142 8.58579C22.7893 8.96086 23 9.46957 23 10V12C23 12.26 22.95 12.5 22.86 12.73L19.84 19.78C19.54 20.5 18.83 21 18 21H9ZM9 19H18.03L21 12V10H12.21L13.34 4.68L9 9.03V19Z" fill="black" />
                            </svg>
                            <p class="font-patua ml-2 p-1 text-base rounded hover:bg-gray-100">
                                いいね
                            </p>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Sidebar ここまで -->

        <!-- main content -->
        <main class="mx-auto w-full py-3 overflow-x-hidden overflow-y-auto">
            <div class="mx-4 mb-4">
                @if (session('flush.message') && session('flush.alert_type') === 'info')
                <div class="flex rounded-md bg-blue-50 p-4 text-sm text-blue-500" x-cloak x-show="showAlert" x-data="{ showAlert: true }">
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
                <div class="flex rounded-md bg-green-50 p-4 text-sm text-green-500" x-cloak x-show="showAlert" x-data="{ showAlert: true }">
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
                <div class="flex rounded-md bg-yellow-50 p-4 text-sm text-yellow-500" x-cloak x-show="showAlert" x-data="{ showAlert: true }">
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
                <div class="flex rounded-md bg-red-50 p-4 text-sm text-red-500" x-cloak x-show="showAlert" x-data="{ showAlert: true }">
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
