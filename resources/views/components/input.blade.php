<div class="w-fit relative" x-data="">
    <input x-ref="input-{{ $name }}" {{ $attributes -> class(["ring relative rounded-md p-1 text-sm bg-slate-200 w-50"])}} name="{{ $name }}" placeholder="{{ $placeholder }}" type="{{ $type }}" value="{{ old($name, $value) }}">
    {{ $slot }}
    @if($type === 'password')
        <button type="button" class="absolute top-0 right-0 flex h-full items-center pr-2"
        x-data="{showClose{{ $name }}: true, showOpen{{ $name }}: false}" 
        @click="
            showClose{{ $name }} = !showClose{{ $name }};
            showOpen{{ $name }} = !showOpen{{ $name }};

            if($refs['input-{{ $name }}'].type === 'password'){
                $refs['input-{{ $name }}'].type='text';
            } else {
                $refs['input-{{ $name }}'].type='password';
            }
        "> 
            <svg x-show="showClose{{ $name }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
            </svg>
            <svg x-show="showOpen{{ $name }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
            </svg>

        </button>

    @endif
</div>