<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Naučne konferencije i simpozijumi</title>
</head>



<body class="bg-blue-100 w-full" >
    <nav class="mb-6 py-3 px-6 flex flex-row items-center justify-between bg-blue-500 shadow-sm border-b ">
        <a href="{{ route('konferencija.index') }}" class="w-fit h-full block text-4xl ">
            Naučne konferencije i simpozijumi
        </a>
        <div class="h-full flex gap-2 flex-row items-center justify-center">
            @auth
                <x-button :href="route('user.edit', auth() -> user())" class="bg-blue-200! hover:bg-blue-700!">Moj nalog</x-button>
                
                <form id="session-destroy-form" action="{{route('logout')}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-submit-button form="session-destroy-form" class="bg-red-200 hover:bg-red-500">Odjavi se</x-submit-button>
                </form>
            @endauth
            @guest
                <x-button :href="route('login')"  class="bg-blue-200! hover:bg-blue-700!">Prijavi se</x-button>
                <x-button :href="route('signup')" class="bg-blue-200! hover:bg-blue-700!">Kreiraj nalog</x-button>
            @endguest
        </div>
    </nav>

    <x-message :success="session('success')"></x-message>
    <x-message :error="session('error')">
        @foreach ($errors -> all() as $error)
            {{ $error }}
        @endforeach
    </x-message>

    <div class="p-3 pt-0">
        {{ $slot }}
    </div>
</body>
</html>