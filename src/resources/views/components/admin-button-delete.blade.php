<form {{ $attributes }} method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="middle none center mr-3 rounded-lg border border-red-700 py-3 px-6 font-sans text-xs font-bold uppercase text-red-700 transition-all hover:opacity-75 focus:ring focus:ring-red-200 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" data-ripple-dark="true">
        削除
    </button>
</form>
