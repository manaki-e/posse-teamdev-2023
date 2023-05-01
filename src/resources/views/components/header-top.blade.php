<div class="mx-10 flex flex-wrap pt-1 flex-col md:flex-row items-center">
        <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <div class="flex">
                <x-application-logo class="w-12 h-12 fill-current text-gray-500 rounded-full"></x-application-logo>
                <x-application-title class="font-bold text-3xl"></x-application-title>
            </div>
        </a>
        <nav class="md:ml-auto flex flex-wrap items-center justify-center">
            <a href="#" class="hover:text-gray-900">マイページ</a>
            <div class="flex justify-center mx-3">
                <div
                    x-data="{
                        open: false,
                        toggle() {
                            if (this.open) {
                                return this.close()
                            }

                            this.$refs.button.focus()

                            this.open = true
                        },
                        close(focusAfter) {
                            if (! this.open) return

                            this.open = false

                            focusAfter && focusAfter.focus()
                        }
                    }"
                    x-on:keydown.escape.prevent.stop="close($refs.button)"
                    x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                    x-id="['dropdown-button']"
                    class="relative"
                >
                    <!-- Button -->
                    <button
                        x-ref="button"
                        x-on:click="toggle()"
                        :aria-expanded="open"
                        :aria-controls="$id('dropdown-button')"
                        type="button"
                        class="flex items-center gap-2 admin-bg-green text-white px-5 py-2.5 rounded-md shadow"
                    >
                        出品・登録

                        <!-- Heroicon: chevron-down -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Panel -->
                    <div
                        x-ref="panel"
                        x-show="open"
                        x-transition.origin.top.left
                        x-on:click.outside="close($refs.button)"
                        :id="$id('dropdown-button')"
                        style="display: none;"
                        class="absolute left-0 mt-2 w-full rounded-md bg-white shadow-md"
                    >
                        <a href="#" class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-green-200 disabled:text-gray-500">
                            アイテム
                        </a>
                        <a href="#" class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-green-200 disabled:text-gray-500">
                            リクエスト
                        </a>
                        <a href="#" class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-green-200 disabled:text-gray-500">
                            イベント
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 bg-black text-white px-5 py-2 rounded-md shadow">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 19C12.3869 19 14.6761 18.0518 16.364 16.364C18.0518 14.6761 19 12.3869 19 10C19 7.61305 18.0518 5.32387 16.364 3.63604C14.6761 1.94821 12.3869 1 10 1C7.61305 1 5.32387 1.94821 3.63604 3.63604C1.94821 5.32387 1 7.61305 1 10C1 12.3869 1.94821 14.6761 3.63604 16.364C5.32387 18.0518 7.61305 19 10 19Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M11 10C11.5304 10 12.0391 10.2107 12.4142 10.5858C12.7893 10.9609 13 11.4696 13 12C13 12.5304 12.7893 13.0391 12.4142 13.4142C12.0391 13.7893 11.5304 14 11 14H8V10M11 10H8M11 10C11.5304 10 12.0391 9.78929 12.4142 9.41421C12.7893 9.03914 13 8.53043 13 8C13 7.46957 12.7893 6.96086 12.4142 6.58579C12.0391 6.21071 11.5304 6 11 6H8V10" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="text-xl">
                    {{$slot}}
                </span>
                pt
            </div>
        </nav>
</div>




