<!-- request_typeとtagで絞り込み -->
<section class="text-gray-600 body-font" x-data="{ activeTab : {{ $default_request_type_id }} }">
    <div class="container px-5 mx-auto flex flex-col">
        <div class="lg:w-4/6 mx-auto">
            <div class="flex flex-col sm:flex-row">
                {{ $filter_by_radio }}
                {{ $filter_by_tags }}
            </div>
        </div>
    </div>
    </div>
</section>
