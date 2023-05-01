<section class="text-gray-600 body-font">
  <div class="container px-5 mx-auto flex flex-col">
    <div class="lg:w-4/6 mx-auto">
      <div class="flex flex-col sm:flex-row">
        <div class="sm:w-1/4 text-center sm:pr-8 sm:py-4">
          <div class="flex flex-col items-center text-center justify-center">
            <h2 class="font-medium title-font text-gray-900 text-lg">利用状況</h2>
            <div class="w-full h-1 bg-gray-500 rounded mt-2 mb-4"></div>
            <div class="flex items-center mb-4">
                <input id="default-radio-1" type="checkbox" value="" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                <label for="default-radio-1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">利用可能</label>
            </div>
            <div class="flex items-center">
                <input checked id="default-radio-2" type="checkbox" value="" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                <label for="default-radio-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">利用不可</label>
            </div>
          </div>
        </div>
        <div class="sm:w-3/4 sm:pl-8 sm:py-4 sm:mt-0 text-center sm:text-left">
            <div class="flex flex-col items-center text-center justify-center">
                <h2 class="font-medium title-font text-gray-900 text-lg">カテゴリ</h2>
                <div class="w-full h-1 bg-gray-500 rounded mt-2 mb-4"></div>
                <div class="flex flex-wrap w-full text-sm font-medium text-gray-900 bg-white sm:flex dark:bg-gray-700 dark:text-white">
                    @for ($i = 0; $i < 5; $i++)
                    <div class="w-24 mx-1 border rounded border-gray-200 dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="vue-checkbox-list" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="vue-checkbox-list" class="w-full py-3 text-sm font-medium text-gray-900 dark:text-gray-300">Vue JS</label>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
