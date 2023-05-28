<!-- radioによる絞り込み：ステータス、 request_typeなど-->
<div class="sm:w-1/4 text-center sm:pr-8 sm:py-4">
    <div class="flex flex-col items-center text-center justify-center">
        <h2 class="font-medium title-font text-gray-900 text-lg ">{{ $radio_name }}</h2>
        <div class="w-full h-1 bg-gray-500 rounded mt-2 mb-4"></div>
        <div class="text-left">
            {{ $radios }}
        </div>
    </div>
</div>
