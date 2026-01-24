<x-layout>
    <x-button-row>
        @auth
            <x-button class="ml-2 text-xl mb-2 md:mb-6" :href="route('konferencija.create')">Dodaj konferenciju</x-button>

            @if (auth() -> user() -> toAdmin() -> exists())
                <x-button class="ml-2 text-xl mb-2 md:mb-6" :href="route('administracija.create')">Dodaj administratora</x-button>
                <x-button class="ml-2 text-xl mb-2 md:mb-6 bg-red-500 hover:bg-red-300" :href="route('administracija.edit', auth() -> user() -> toAdmin)">Obriši administratore</x-button>
                <x-button class="ml-2 text-xl mb-2 md:mb-6" :href="route('lokacija.index')">Lokacije</x-button>
                <x-button class="ml-2 text-xl mb-2 md:mb-6" :href="route('analitika.index')">Analitika</x-button>
            @endif
        @endif
    </x-button-row>
    <form id='filter-form' action="{{route('konferencija.index')}}" method="GET">
        @auth
            <x-button-row class="ml-2 mb-4!">
                <p>Filteri:</p>
                @if(!auth() -> user() -> toAdmin() -> exists())
                    <x-input class="w-fit ring-0 inline" name="filters" type="radio" value="odobreno" :checked="request('filters') === 'odobreno' or !request('filters')"></x-input><div class="input">Svi</div>
                @endif
                <x-input class="w-fit ring-0 inline" name="filters" type="radio" value="my" :checked="request('filters') === 'my'"></x-input><div class="input">Moje konferencije</div>
                @if(auth() -> user() -> toAdmin() -> exists())
                    <x-input class="w-fit ring-0 inline" name="filters" type="radio" value="ceka" :checked="request('filters') === 'ceka'"></x-input><div class="input">Na čekanju</div>
                    <x-input class="w-fit ring-0 inline" name="filters" type="radio" value="odobreno" :checked="request('filters') === 'odobreno' or !request('filters')"></x-input><div class="input">Odobreni</div>
                    <x-input class="w-fit ring-0 inline" name="filters" type="radio" value="odbijeno" :checked="request('filters') === 'odbijeno'"></x-input><div class="input">Odbijeni</div>
                @endif
                <x-submit-button form="filter-form">Primijeni</x-submit-button>
            </x-button-row>
        @endauth
    </form>
    @foreach ($konferencije as $konferencija)
        <x-card class="text-xl">
            <x-block>
                <p class="mb-1">{{ $konferencija -> ime }}</p>  
                <p class="text-base text-slate-400">{{ $konferencija -> toKreator -> ime }} {{ $konferencija -> toKreator -> prezime }} </p>      
            </x-block>
            <x-button :href="route('konferencija.show', $konferencija)">
                Prikaži
            </x-button>
        </x-card>
    @endforeach
    <nav class="flex flex-row justify-center mt-4 mb-1">
        {{ $konferencije -> links() }}
    </nav>
</x-layout>