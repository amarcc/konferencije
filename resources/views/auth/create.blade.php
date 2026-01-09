<x-layout>
    <x-card>
        <form id="main-form" action="{{ route("auth.store") }}" method="POST">
            @csrf
            <x-block>
               <x-label>
                   Username ili email:
               </x-label>
               <x-input name="usernameoremail" type="text" :value="request('usernameoremail')"></x-input>
            </x-block>
            <x-block>
               <x-label>
                   Password:
               </x-label>
               <x-input name="password" type="password" :value="request('password')"></x-input>
            </x-block>
            <x-block class="flex flex-row gap-2 justify-start items-center">
                <x-input class="w-fit! ring-0 borderc" name="remember" type="checkbox"></x-input>
                <div class="text-sm">Zapamti me</div>
            </x-block>
            
            <x-submit-button form="main-form" class="mb-2">
                Uloguj se
            </x-submit-button>
            <x-block class="text-sm mb-2!">
                Nemate nalog? Napravite novi
                <x-link :href="route('user.create')">ovđe</x-link>
            </x-block>
        </form>
    </x-card>
</x-layout>