<x-layout>
    <x-card>
        <form id="main-form" action="{{route('rad.status', $konferencija)}}" method="POST">
            @csrf
            @method('PUT')
            <x-block>
                <x-label class="mb-2">Unesite status</x-label>
                <select name="status" class="w-50 text-sm p-1 text bg-slate-200 ring rounded-md">
                    <option value="">Izaberi status</option>
                    <option value="odobreno">Odobreno</option>
                    <option value="odbijeno">Odbijeno</option>
                </select>
            </x-block>
            <x-button-row>
                <x-submit-button form="main-form">Promijeni status</x-submit-button>
            </x-button-row>
        </form>
    </x-card>
</x-layout>