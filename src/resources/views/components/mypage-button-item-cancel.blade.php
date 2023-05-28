<div x-data="{ showModal: false }" x-on:keydown.window.escape="showModal = false">
    <div class="flex justify-center">
        <a @click="showModal = true">
            <button class="flex select-none items-center gap-3 rounded-lg border border-blue-400 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-blue-400 transition-all hover:opacity-75 focus:ring focus:ring-pink-200 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button" data-ripple-dark="true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-5 w-5">
                    {{ $logo_path }}
                </svg>
                {{ $content }}
            </button>
        </a>
    </div>
    <div x-cloak x-show="showModal" x-transition.opacity class="fixed inset-0 z-10 bg-gray-700/50"></div>
    <div x-cloak x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
        <div class="mx-auto overflow-hidden rounded-lg bg-white shadow-xl sm:w-full sm:max-w-xl">
            <div class="relative p-6">
                <div class="flex gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 whitespace-normal">
                        <h3 class="text-lg font-medium text-secondary-900">{{ $modal_title }}</h3>
                        <div class="mt-2 text-sm text-secondary-500">{{ $modal_description }}</div>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-3">
                    <form {{ $attributes }} method="post">
                        @csrf
                        {{ $method }}
                        {{ $form_slot }}
                        <button type="submit" class="w-full rounded-lg border border-blue-500 bg-blue-500 px-4 py-2 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-blue-700 hover:bg-blue-700 focus:ring focus:ring-blue-200 disabled:cursor-not-allowed disabled:border-blue-300 disabled:bg-blue-300">{{ $content }}</button>
                    </form>
                    <button @click="showModal = false" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-100 focus:ring focus:ring-gray-100 disabled:cursor-not-allowed disabled:border-gray-100 disabled:bg-gray-50 disabled:text-gray-400">戻る</button>
                </div>
            </div>
        </div>
    </div>
</div>
