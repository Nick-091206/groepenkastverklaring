<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Groepenkast Verklaring &mdash; Stap 1 van 2
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <p class="mb-6 text-gray-600">Vul uw naam en adresgegevens in en geef aan hoeveel groepen uw groepenkast heeft.</p>

                <form method="POST" action="{{ route('wizard.step1.store') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="naam" value="Naam" />
                        <x-text-input id="naam" name="naam" type="text" class="mt-1 block w-full" :value="old('naam')" required autofocus />
                        <x-input-error :messages="$errors->get('naam')" class="mt-1" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="adres" value="Adres" />
                        <x-text-input id="adres" name="adres" type="text" class="mt-1 block w-full" :value="old('adres')" required />
                        <x-input-error :messages="$errors->get('adres')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="postcode" value="Postcode" />
                            <x-text-input id="postcode" name="postcode" type="text" class="mt-1 block w-full" :value="old('postcode')" required />
                            <x-input-error :messages="$errors->get('postcode')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="stad" value="Woonplaats" />
                            <x-text-input id="stad" name="stad" type="text" class="mt-1 block w-full" :value="old('stad')" required />
                            <x-input-error :messages="$errors->get('stad')" class="mt-1" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="aantal_groepen" value="Aantal groepen" />
                        <x-text-input id="aantal_groepen" name="aantal_groepen" type="number" class="mt-1 block w-32" :value="old('aantal_groepen', 10)" min="1" max="100" required />
                        <x-input-error :messages="$errors->get('aantal_groepen')" class="mt-1" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>Volgende &rarr;</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
