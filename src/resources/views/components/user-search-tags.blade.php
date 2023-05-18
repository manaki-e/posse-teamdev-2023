<section class="text-gray-600 body-font">
    <div class="container px-5 mx-auto flex flex-col">
        <div class="lg:w-4/6 mx-auto">
            <div class="flex flex-col sm:flex-row">
                <div class="sm:w-1/4 text-center sm:pr-8 sm:py-4">
                    <div class="flex flex-col items-center text-center justify-center">
                        <h2 class="font-medium title-font text-gray-900 text-lg ">{{ $category1}}</h2>
                        <div class="w-full h-1 bg-gray-500 rounded mt-2 mb-4"></div>
                        <div class="flex items-center mb-4">
                            <input id="box-1" type="checkbox" value="" name=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                            <label for="box-1"
                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $available}}</label>
                        </div>
                        <div class="flex items-center">
                            <input id="box-2" type="checkbox" value="" name=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                            <label for="box-2"
                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $unavailable}}</label>
                        </div>
                    </div>
                </div>
                <div class="sm:w-3/4 sm:pl-8 sm:py-4 sm:mt-0 text-center sm:text-left">
                    <div class="flex flex-col items-center text-center justify-center">
                        <h2 class="font-medium title-font text-gray-900 text-lg">カテゴリ</h2>
                        <div class="w-full h-1 bg-gray-500 rounded mt-2 mb-4"></div>
                        <div
                            class="flex flex-wrap w-full text-sm font-medium text-gray-900 bg-white sm:flex dark:bg-gray-700 dark:text-white">
                            {{ $category_tags }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
