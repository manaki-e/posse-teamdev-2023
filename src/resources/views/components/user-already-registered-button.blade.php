<div class="py-2 w-full">
    <button disabled {{ $attributes->merge(['class' => 'block w-full rounded-lg my-1 py-3 border-2 font-bold shadow-md text-center text-sm transition-all align-middle hover:shadow-lg hover:opacity-75 '.$textColor .' ' .$bgColor .' ' .$borderColor]) }}>
        {{ $button }}
    </button>
</div>
