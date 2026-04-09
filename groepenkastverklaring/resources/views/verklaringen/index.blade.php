<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
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
                        <p class="mb-4">Er zijn nog geen verklaringen.</p>
                        <a href="{{ route('wizard.step1') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md font-semibold text-xs uppercase hover:bg-gray-700">
                            + Nieuwe Verklaring Aanmaken
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @if($showOwner)
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Eigenaar</th>
                                    @endif
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naam</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adres</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Groepen</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aangemaakt</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($verklaringen as $verklaring)
                                    @php $isOwner = $verklaring->user_id === auth()->id(); @endphp
                                    <tr class="hover:bg-gray-50 {{ $isOwner ? 'cursor-pointer' : '' }}" @if($isOwner) x-data @click="window.location='{{ route('verklaringen.edit', $verklaring) }}'" @endif>
                                        @if($showOwner)
                                            <td class="px-4 py-3 text-sm text-gray-500">{{ $verklaring->user->name }}</td>
                                        @endif
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $verklaring->naam }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $verklaring->adres }}, {{ $verklaring->postcode }} {{ $verklaring->stad }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $verklaring->aantal_groepen }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $verklaring->created_at->format('d-m-Y') }}</td>
                                        <td class="px-4 py-3 text-right" @click.stop>
                                            <div class="flex justify-end gap-1">
                                                <a href="{{ route('verklaringen.download', $verklaring) }}" class="p-2 text-green-600 hover:bg-green-100 rounded" title="Download PDF">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                </a>
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
