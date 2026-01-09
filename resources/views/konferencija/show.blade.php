<x-layout>
    <x-card>
        <x-block>
            <x-label>
                Ime konferencije:
            </x-label>
            <p class="pl-2">{{ $konferencija -> ime }}</p>  
        </x-block>
        <x-block>
            <x-label>
                Kreator konferencije:
            </x-label>
            <p class="pl-2"> {{$konferencija -> toKreator -> ime}}  {{$konferencija -> toKreator -> prezime}} </p>      
        </x-block>
        <x-block>
            <x-label>Predavaci:</x-label>
            @foreach ($predavaci as $predavac)
                <p class="pl-2">{{$predavac -> toUser -> ime}} {{$predavac -> toUser -> prezime}}</p>
            @endforeach
        </x-block>
        <x-block>
            <x-label>Vrijeme pocetka:</x-label>
            <p class="pl-2">{{ $konferencija -> pocetak > now() ? $konferencija -> pocetak -> format('d.m.Y. H:i') : $konferencija -> pocetak -> diffForHumans()}}</p>
        </x-block> 
        <x-block>
            <x-label>
                Lokacija:
            </x-label>
            <p class="pl-2"> {{$konferencija -> toLokacija -> ime}} </p>      
        </x-block>
        <x-block>
            <x-label>
                Adresa:
            </x-label>
            <p class="pl-2"> {{$konferencija -> toLokacija -> adresa}} </p>      
        </x-block>
        <x-block>
            <x-label>
                Broj preostalih mjesta:
            </x-label>
            <p class="pl-2"> {{$konferencija -> br_mjesta}} </p>      
        </x-block>
        <x-button-row>
            <x-button :href="route('rad.download', $konferencija)">Preuzmi rad</x-button>
        </x-button-row>
        <x-button-row>
            @auth
                @if(auth() -> user() -> id === $konferencija -> toKreator -> id)
                    <x-button :href="route('konferencija.edit', $konferencija)">Promijeni</x-button>
                @endif
                
                @if($prijava === null)
                    <form id="prijava-form" action="{{ route('konferencija.prijava.store', $konferencija) }}" method="POST">
                        @csrf
                        <input type="hidden" name="konferencija_id" value="{{ $konferencija->id }}">
                        <x-submit-button form="prijava-form">Prijavi se</x-submit-button>
                    </form>
                @endif
                @if($prijava !== null)
                    <form id="prijava-delete" action="{{ route('konferencija.prijava.destroy', [$konferencija, $prijava]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-submit-button form="prijava-delete" class="bg-red-500 hover:bg-red-300">Poništi prijavu</x-submit-button>
                    </form>
                @endif
                @if(auth() -> user() -> toAdmin() -> exists() and auth() -> user() -> id != $konferencija -> kreator)
                    <x-button :href="route('rad.ocjena', $konferencija)">Ocijeni rad</x-button>
                @endif
            @endauth
            <x-button :href="route('konferencija.index')">Nazad</x-button>
        </x-button-row>
    </x-card>
</x-layout>