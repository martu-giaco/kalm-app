<button
    type="button"
    :disabled="disabled || loading"
    class="w-full px-5 py-3 rounded-xl text-white font-bold transition cursor-pointer disabled:opacity-80 disabled:cursor-not-allowed bg-(--kälm-dark)"
    style="font-family: 'Mulish';">
    {{ $slot }}
</button>
