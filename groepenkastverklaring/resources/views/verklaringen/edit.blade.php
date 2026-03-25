<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verklaring Bewerken
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('verklaringen.update', $verklaring) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Algemene Gegevens</h3>

                        <div class="mb-4">
                            <x-input-label for="naam" value="Naam" />
                            <x-text-input id="naam" name="naam" type="text" class="mt-1 block w-full" :value="old('naam', $verklaring->naam)" required />
                            <x-input-error :messages="$errors->get('naam')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="adres" value="Adres" />
                            <x-text-input id="adres" name="adres" type="text" class="mt-1 block w-full" :value="old('adres', $verklaring->adres)" required />
                            <x-input-error :messages="$errors->get('adres')" class="mt-1" />
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="postcode" value="Postcode" />
                                <x-text-input id="postcode" name="postcode" type="text" class="mt-1 block w-full" :value="old('postcode', $verklaring->postcode)" required />
                                <x-input-error :messages="$errors->get('postcode')" class="mt-1" />
                            </div>
                            <div>
                                <x-input-label for="stad" value="Woonplaats" />
                                <x-text-input id="stad" name="stad" type="text" class="mt-1 block w-full" :value="old('stad', $verklaring->stad)" required />
                                <x-input-error :messages="$errors->get('stad')" class="mt-1" />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="aantal_groepen" value="Aantal groepen" />
                            <x-text-input id="aantal_groepen" name="aantal_groepen" type="number" class="mt-1 block w-32" :value="old('aantal_groepen', $verklaring->aantal_groepen)" min="1" max="100" required />
                            <x-input-error :messages="$errors->get('aantal_groepen')" class="mt-1" />
                        </div>
                    </div>

                    <div class="mb-6" x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="flex items-center justify-between w-full text-left">
                            <h3 class="text-lg font-medium text-gray-900">Groepen Indeling</h3>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" x-collapse class="mt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @for ($i = 1; $i <= $verklaring->aantal_groepen; $i++)
                                    <div>
                                        <x-input-label for="groep_{{ $i }}" value="Groep {{ $i }}" />
                                        <x-text-input id="groep_{{ $i }}" name="groep_{{ $i }}" type="text" class="mt-1 block w-full" :value="old('groep_' . $i, $verklaring->groepen[$i] ?? '')" />
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('verklaringen.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Terug</a>
                        <x-primary-button>Opslaan</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
