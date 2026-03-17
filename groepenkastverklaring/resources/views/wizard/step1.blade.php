<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Groepenkast Verklaring &mdash; Stap 1 van 2
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <p class="mb-6 text-gray-600">Vul uw naam en adresgegevens in en geef aan hoeveel groepen uw groepenkast heeft.</p>

                <form method="POST" action="{{ route('wizard.step1.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="naam">Naam</label>
                        <input type="text" id="naam" name="naam" value="{{ old('naam') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('naam') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="adres">Adres</label>
                        <input type="text" id="adres" name="adres" value="{{ old('adres') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('adres') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="postcode">Postcode</label>
                            <input type="text" id="postcode" name="postcode" value="{{ old('postcode') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('postcode') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="stad">Stad / Gemeente</label>
                            <input type="text" id="stad" name="stad" value="{{ old('stad') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('stad') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="aantal_groepen">Aantal groepen</label>
                        <input type="number" id="aantal_groepen" name="aantal_groepen"
                            value="{{ old('aantal_groepen', 10) }}" min="1" max="100"
                            class="w-32 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('aantal_groepen') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-md">
                            Volgende &rarr;
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
