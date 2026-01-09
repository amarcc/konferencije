<div>
    <form id="main-form" 
    @if($admin === False)
        action="{{ $formType === 'create' ? route('user.store') : route('user.update', $user) }}" 
    @endif
    @if($admin === True)
        action="{{ $formType === 'create' ? route('administracija.store') : route('administracija.update', $user) }}"
    @endif
    method="POST">
        @csrf
        @if($formType === 'edit')
            @method("PUT")
        @endif
        <x-block>
            <x-label>
                Ime:
            </x-label>
            <x-input name="ime" type="text" :value="$formType === 'create' ? request('ime') : $user -> ime"></x-input>
        </x-block>
        <x-block>
            <x-label>
                Prezime:
            </x-label>
            <x-input name="prezime" type="text" :value="$formType === 'create' ? request('prezime') : $user -> prezime"></x-input>
        </x-block>
        <x-block>
            <x-label>
                Username:
            </x-label>
            <x-input name="username" type="text" :value="$formType === 'create' ? request('username') : $user -> username"></x-input>
        </x-block>
        <x-block>
            <x-label>
                Email:
            </x-label>
            <x-input name="email" type="email" :value="$formType === 'create' ? request(key: 'email') : $user -> email"></x-input>
        </x-block>
        <x-block>
            <x-label>
                Datum rođenja:
            </x-label>
            <x-input name="datum_rodjenja" type="date" :value="$formType === 'create' ? request('datum_rodjenja') : $user -> datum_rodjenja"></x-input>
        </x-block>
        <x-block>
            <x-label>
                Password:
            </x-label>
            <x-input name="password" type="password"></x-input>
        </x-block>
        <x-block>
            <x-label>
                Ponovite password:
            </x-label>
            <x-input name="rep_password" type="password"></x-input>
        </x-block>
        
        @if($admin === False)
            @if($formType === 'create')
                <x-block class="flex flex-row gap-2 justify-start items-center">
                    <x-input class="w-fit! ring-0 border" name="remember" type="checkbox"></x-input>
                    <div class="text-sm">Zapamti me</div>
                </x-block>
            @endif
        @endif
    </form>

    <x-button-row class="my-2!">
        <x-submit-button form="main-form">{{ $formType === 'create' ? 'Kreiraj nalog' : 'Promijeni' }} </x-submit-button>
        @if($formType === 'edit')
            <form action="{{ route('user.destroy', $user) }}" method="POST">
                @csrf
                @method("DELETE")
                <x-submit-button>Obriši</x-submit-button>
            </form>
        @endif
        @auth
            <x-button :href="route('konferencija.index')">Nazad</x-button>
        @endauth
    </x-button-row>

    @if($formType === 'create')
        <x-block class="text-sm mb-2!">
            Već imate nalog? Prijavite se 
            <x-link :href="route('auth.create')">ovđe</x-link>
        </x-block>
    @endif
</div>