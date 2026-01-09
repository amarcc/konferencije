<x-layout>
    <x-card>
        <form id="main-form" action="{{ route('lokacija.store') }}" method="POST">
            @csrf
            <x-block>
                <x-label>
                    Ime lokacije:
                </x-label>
                <x-input name="ime" type="text" :value="request('ime')"></x-input>
            </x-block>
            <x-block>
                <x-label>
                    Adresa:
                </x-label>
                <x-input name="adresa" type="text" :value="request('adresa')"></x-input>
            </x-block>
            <x-block>
                <x-label>
                    Broj mjesta:
                </x-label>
                <x-input name="br_mjesta" type="number" :value="request('br_mjesta')"></x-input>
            </x-block>
            <x-button-row>
                <x-submit-button form="main-form">Dodaj</x-submit-button>
                <x-button :href="route('lokacija.index')">Nazad</x-button>
            </x-button-row>
        </form>
    </x-card>
</x-layout>