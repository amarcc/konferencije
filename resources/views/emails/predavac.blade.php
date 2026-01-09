<body class="flex h-full w-full justify-center items-center bg-blue-500">
    <h4 class="text-2xl">Naučne konferencije i simpozijumi</h4>
    <x-card class="text-lg">
        Dodani ste kao predavač za konferenciju <strong><a href="{{ route('konferencija.show', $kon) }}">{{ $kon -> ime }}</a></strong> od <strong>{{ $kon -> toKreator -> ime }}  {{ $kon -> toKreator -> prezime }}</strong>
    </x-card>
</body>
