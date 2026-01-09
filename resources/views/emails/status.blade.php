<body class="flex h-full w-full justify-center items-center bg-blue-500">
    <h4 class="text-2xl">Naučne konferencije i simpozijumi</h4>
    <x-card class="text-lg">
        Status vaše konferencije <strong><a href="{{ route('konferencija.show', $kon) }}">{{ $kon -> ime }}</a></strong> je promjenjen na <strong>{{ $kon -> status }}</strong>
    </x-card>
</body>
