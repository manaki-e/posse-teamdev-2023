<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{"Peer Perk"}}</title>
    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }
    </style>
</head>

<body class="admin-bg-basic font-family-karla">
    <div class="flex overflow-hidden">
        <aside class="fixed z-50 admin-bg-green h-screen w-64 hidden sm:block shadow-xl">
            <div class="flex flex-col justify-between h-full">
                <x-admin-sidebar></x-admin-sidebar>
                <div class="mx-auto w-full text-white text-sm">
                    <x-admin-nav-link :href="route('items.index')">
                        <x-slot name="icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_663_5457)">
                                    <path d="M6.04598 11.6776C6.88355 10.2627 8.16287 9.16221 9.68709 8.54554C11.2113 7.92886 12.8959 7.83016 14.4817 8.26463C16.0675 8.69909 17.4666 9.64264 18.4637 10.9501C19.4608 12.2575 20.0005 13.8564 20 15.5006C20 15.7658 20.1053 16.0202 20.2929 16.2077C20.4804 16.3953 20.7348 16.5006 21 16.5006C21.2652 16.5006 21.5196 16.3953 21.7071 16.2077C21.8946 16.0202 22 15.7658 22 15.5006C22.0001 13.4893 21.3619 11.5299 20.1773 9.90455C18.9927 8.27917 17.3227 7.0717 15.408 6.45603C13.4933 5.84037 11.4326 5.84827 9.52265 6.47861C7.61271 7.10895 5.9521 8.32919 4.77998 9.96361L4.24298 6.91861C4.19697 6.65737 4.04906 6.42511 3.8318 6.27293C3.61454 6.12074 3.34572 6.0611 3.08448 6.10711C2.82324 6.15313 2.59098 6.30103 2.4388 6.51829C2.28661 6.73556 2.22697 7.00437 2.27298 7.26561L3.31498 13.1746C3.36135 13.4357 3.50955 13.6678 3.72698 13.8196C3.86867 13.9146 4.03052 13.9754 4.19974 13.9971C4.36896 14.0188 4.5409 14.0008 4.70198 13.9446L10.382 12.9436C10.6432 12.8976 10.8755 12.7497 11.0277 12.5324C11.1798 12.3152 11.2395 12.0463 11.1935 11.7851C11.1475 11.5239 10.9996 11.2916 10.7823 11.1394C10.565 10.9872 10.2962 10.9276 10.035 10.9736L6.04598 11.6776Z" fill="white" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_663_5457">
                                        <rect width="24" height="24" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </x-slot>
                        {{ __('ユーザー画面へ') }}
                    </x-admin-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        <button type="submit" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                            @csrf
                            <div class="w-8 h-8 mr-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 7L15.59 8.41L18.17 11H8V13H18.17L15.59 15.58L17 17L22 12L17 7ZM4 5H12V3H4C2.9 3 2 3.9 2 5V19C2 20.1 2.9 21 4 21H12V19H4V5Z" fill="currentColor" />
                                </svg>
                            </div>
                            {{ __('ログアウト') }}
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        <div class="h-full w-full relative overflow-y-auto mx-4 pl-64">
            <div class="flex">
                <x-application-logo class="w-16 h-16 fill-current text-gray-500 rounded-full"></x-application-logo>
                <x-application-title class="font-bold text-4xl"></x-application-title>
            </div>

            <div class="space-y-4">
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

            <main>
                <x-admin-title>
                    <x-slot name="title">
                        {{ $title }}
                    </x-slot>
                    <x-slot name="description">
                        {{ $description }}
                    </x-slot>
                </x-admin-title>

                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
