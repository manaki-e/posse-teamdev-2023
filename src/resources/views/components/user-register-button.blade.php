<!--
    引数は背景と文字と枠線の色
        $bgColor, $textColor, $borderColor

    ** 枠線が入らない場合は背景色と同色を指定する
-->

<div class="py-2 w-full">
    <button type="submit" {{ $attributes->merge(['class' => 'block w-full rounded-lg my-1 py-3 border-2 font-bold shadow-md text-center text-sm transition-all align-middle hover:shadow-lg hover:opacity-75 '.$textColor .' ' .$bgColor .' ' .$borderColor]) }} >
        {{ $button }}
    </button>
</div>
