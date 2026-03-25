<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mijn Verklaringen
            </h2>
            <a href="{{ route('wizard.step1') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                + Nieuwe Verklaring
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                @if($verklaringen->isEmpty())
                    <div class="p-8 text-center text-gray-500">
                        <p class="mb-4">Je hebt nog geen verklaringen aangemaakt.</p>
                        <a href="{{ route('wizard.step1') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md font-semibold text-xs uppercase hover:bg-gray-700">
                            + Nieuwe Verklaring Aanmaken
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naam</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adres</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Groepen</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aangemaakt</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($verklaringen as $verklaring)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $verklaring->naam }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $verklaring->adres }}, {{ $verklaring->postcode }} {{ $verklaring->stad }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $verklaring->aantal_groepen }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $verklaring->created_at->format('d-m-Y') }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex justify-end gap-1">
                                                <a href="{{ route('verklaringen.edit', $verklaring) }}" class="p-2 text-blue-600 hover:bg-blue-100 rounded" title="Bewerken">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <a href="{{ route('verklaringen.download', $verklaring) }}" class="p-2 text-green-600 hover:bg-green-100 rounded" title="Download PDF">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                </a>
                                                <form method="POST" action="{{ route('verklaringen.destroy', $verklaring) }}" class="inline" onsubmit="return confirm('Weet je zeker dat je deze verklaring wilt verwijderen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded" title="Verwijderen">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                        {{ $verklaringen->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
