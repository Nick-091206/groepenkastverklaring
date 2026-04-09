<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gebruikersbeheer
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md font-semibold text-xs uppercase hover:bg-gray-700">
                    + Nieuwe Gebruiker
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naam</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">E-mail</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Admin</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aangemaakt</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 cursor-pointer" x-data @click="window.location='{{ $user->id === auth()->id() ? route('profile.edit') : route('admin.users.edit', $user) }}'">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($user->is_admin)
                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Ja</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Nee</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $user->created_at->format('d-m-Y') }}</td>
                                    <td class="px-4 py-3 text-right" @click.stop>
                                        <div class="flex justify-end gap-1">
                                            @if($user->id === auth()->id())
                                                <a href="{{ route('profile.edit') }}" class="p-2 text-gray-600 hover:bg-gray-100 rounded" title="Mijn profiel">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                </a>
                                            @else
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" @submit.prevent="if(confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')) $el.submit()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded" title="Verwijderen">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
