<!--
    白背景に枠線と文字が色付きのボタン
    引数は文字と枠線の色
        textColorとborderColor
-->

<div class="py-2 w-full">
    <button type="submit"
        {{ $attributes->merge(['class' => 'block w-full rounded-lg my-1 py-3 border-2 font-bold shadow-md text-center text-sm bg-white transition-all align-middle hover:shadow-lg hover:opacity-75 '.$textColor .' ' .$borderColor]) }}>
        {{ $button }}
    </button>
</div>
