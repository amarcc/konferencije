<div 
@class([
    'px-8 py-2 rounded-full w-fit mx-5 mb-6 border text-xl' => $success != null or $error != null or $slot != '',
    "bg-green-400" => $success != null,
    "bg-red-400" => $error != null or $slot != ''
])
>

    {{ $success != null ? $success : '' }}
    {{ $error != null ? $error : '' }}
    {{ $slot }}
</div>