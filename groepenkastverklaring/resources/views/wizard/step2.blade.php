<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Groepenkast Verklaring &mdash; Stap 2 van 2
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <p class="mb-6 text-gray-600">Vul per groep een omschrijving in (optioneel).</p>

                <form method="POST" action="{{ route('wizard.step2.store') }}">
                    @csrf

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-3 py-2 text-left w-20">Groep</th>
                                    <th class="border border-gray-300 px-3 py-2 text-left">Omschrijving</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (range(1, $aantalGroepen) as $i)
                                    <tr class="{{ $i % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                                        <td class="border border-gray-300 px-3 py-2 font-medium text-center">{{ $i }}</td>
                                        <td class="border border-gray-300 px-1 py-1">
                                            <x-text-input
                                                name="groep_{{ $i }}"
                                                type="text"
                                                class="w-full border-0 shadow-none bg-transparent focus:ring-0"
                                                :value="old('groep_' . $i)" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-between mt-6">
                        <x-secondary-button onclick="window.location='{{ route('wizard.step1') }}'">
                            &larr; Terug
                        </x-secondary-button>
                        <x-primary-button>
                            PDF genereren &amp; downloaden
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
