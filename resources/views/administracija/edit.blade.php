<x-layout>
    <x-card>
        <form id="delete-form" action="{{ route('administracija.destroy', auth() -> user() -> toAdmin) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-block>
                <x-label class="mb-2">
                    Username:
                </x-label>
                <x-input type="text" name="username"></x-input>
                
            </x-block>
            <x-submit-button class="bg-red-500 hover:bg-red-300" form="delete-form">Obriši</x-submit-button>
        </form>
    </x-card>
</x-layout>