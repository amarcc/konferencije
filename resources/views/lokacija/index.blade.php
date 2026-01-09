<x-layout>
    <x-button-row>
        <x-button class="ml-2 text-xl mb-6" :href="route('lokacija.create')">Dodaj lokaciju</x-button>
    </x-button-row>
    @foreach ($locs as $loc)    
        <x-card>
            <x-block>
                <x-label>
                    Ime lokacije:
                </x-label>
                <p>{{$loc -> ime}}</p>    
            </x-block>
            <x-block>
                <x-label>Adresa:</x-label>
                <p class="mb-1">{{ $loc -> adresa }}</p>
            </x-block>
            <x-block>
                <x-label>
                    Broj mjesa:
                </x-label>
                <p class="mb-1">{{ $loc -> br_mjesta }}</p>
            </x-block>
            <x-button-row class="mt-5!">
                <form id="delete-form" action="{{ route('lokacija.destroy', $loc) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-submit-button form="delete-form" class="bg-red-500 hover:bg-red-300">Obriši</x-submit-button>
                </form>
            </x-button-row>
        </x-card>
    @endforeach
</x-layout> 