<x-layout>
    <div class="h-full w-full flex flex-row justify-center items-center text-center">
        <x-card>
            <div class="flex flex-col m-4! gap-4 text-lg justify-center items-center ">
                <div class="text-slate-400">
                    Broj kreiranih konferencija:
                </div>
                <div class="text-2xl">
                    {{ $kon }}
                </div>
            </div>
        </x-card>

        <x-card>
            <div class="flex flex-col m-4! gap-4 text-lg justify-center items-center ">
                <div class="text-slate-400">
                    Broj korisnika:
                </div>
                <div class="text-2xl">
                    {{ $users }}
                </div>
            </div>
        </x-card>

        <x-card>
            <div class="flex flex-col m-4! gap-4 text-lg justify-center items-center ">
                <div class="text-slate-400">
                    Broj prijava za konferencije:
                </div>
                <div class="text-2xl">
                    {{ $prijave }}
                </div>
            </div>
        </x-card>

        <x-card>
            <div class="flex flex-col m-4! gap-4 text-lg justify-center items-center ">
                <div class="text-slate-400">
                    Broj odobrenih konferencija:
                </div>
                <div class="text-2xl">
                    {{ $allowed }}
                </div>
            </div>
        </x-card>

        <x-card>
            <div class="flex flex-col m-4! gap-4 text-lg justify-center items-center ">
                <div class="text-slate-400">
                    Broj odbijenih konferencija:
                </div>
                <div class="text-2xl">
                    {{ $rejected }}
                </div>
            </div>
        </x-card>

    </div>
</x-layout>