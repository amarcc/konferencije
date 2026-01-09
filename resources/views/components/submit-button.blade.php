<button form="{{ $form }}" type="submit" {{ $attributes -> class(["rounded-full h-fit w-fit block bg-blue-500 px-3 py-1 ring border-black text-sm hover:bg-blue-300"])}}>
    {{ $slot }}
</button>