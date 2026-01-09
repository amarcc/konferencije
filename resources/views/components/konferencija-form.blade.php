<link >
<div>
    <form id="main-form" action="{{ $formType == 'edit' ? route('konferencija.update', $konferencija) : route('konferencija.store') }}" 
    @if($formType === 'create')
        enctype="multipart/form-data"
    @endif
    method="POST">
        @csrf
        @if($formType === 'edit')
            @method("PUT")
        @endif
        <x-block>
            <x-label class="mb-2">
                Ime konferencije:
            </x-label>
            <x-input name="ime" type="text" :value="$formType === 'edit' ? $konferencija -> ime : request('ime')">
            </x-input>
        </x-block>
        <x-block>
            <x-label class="mb-2">
                Datum konferencije:
            </x-label>
            <x-input name="pocetak" type="datetime-local" :value="$formType === 'edit' ? $konferencija -> pocetak : request('pocetak')">
            </x-input>
        </x-block>

        <x-block>
            <x-label class="mb-2">
                Lokacija:
            </x-label>
            <select name="lokacija" class="w-50 text-sm p-1 text bg-slate-200 ring rounded-md">
                <option value="">Odaberi lokaciju</option>
                @foreach ($locs as $loc)
                    <option value="{{ $loc -> id }}" @if($formType === "edit" and $loc -> id === $konferencija -> lokacija) selected @endif>{{$loc -> ime}} Broj mjesta: {{$loc -> br_mjesta}}</option>
                @endforeach
            </select>
        </x-block>

        <x-block>
            <x-label class="block mb-2">{{ $formType === 'create' ? 'Izaberite rad' : 'Izaberite novi rad:' }}</x-label>
            <x-input type="file" name="file" accept=".pdf"></x-input>
        </x-block>

        @php
            $initProfessors = [];
            if($formType === 'create'){
                array_push($initProfessors, auth() -> user() -> username);
            } else {
                foreach($konferencija -> toPredavaci as $predavac){
                    array_push($initProfessors, $predavac -> toUser -> username);
                }
            }
        @endphp
        <x-block id="professors-div" x-data='{ 
            professors: {{ json_encode($initProfessors) }}
        }'>
            <x-label class="mb-2">
                Predavači:
            </x-label>
            <template x-for="(professor, index) in professors" :key="index">
                <div class="mb-4 flex justify-start gap-2 ">
                    <x-input
                        type="text"
                        name="professors[]"
                        x-model="professors[index]"
                        placeholder="Unesite username predavača"
                    ></x-input>
                    <x-submit-button
                        type="button"
                        @click="professors.splice(index, 1)"
                        class="bg-red-500 hover:bg-red-300"
                    >
                        Obriši
                    </x-submit-button>
                </div>
            </template>
            <x-submit-button
                type="button"
                @click="professors.push('')"
            >
                Dodaj predavača               
            </x-submit-button>
        </x-block>
    </form>
    <x-button-row>
        <x-submit-button form="main-form" >{{$formType == 'edit' ? 'Promijeni' : "Dodaj"}}</x-submit-button>
        @if($formType === 'edit')
            <form id="delete-form" action="{{ route('konferencija.destroy', $konferencija) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-submit-button form="delete-form" :href="route('konferencija.destroy', $konferencija)" class=" bg-red-500 hover:bg-red-300">Obriši</x-submit-button>
            </form>
        @endif
        <x-button :href="$formType === 'edit' ? route('konferencija.show', $konferencija) : route('konferencija.index')">Nazad</x-button>
    </x-button-row>
</div>