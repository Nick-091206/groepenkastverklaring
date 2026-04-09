<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verklaring Bewerken
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('verklaringen.update', $verklaring) }}" x-data="tagDragManager({
                    @for ($i = 1; $i <= $verklaring->aantal_groepen; $i++)
                        {{ $i }}: {
                            tags: {{ Js::from(array_values(array_filter(array_map('trim', explode(' + ', $verklaring->groepen[$i] ?? ''))))) }},
                            input: ''
                        },
                    @endfor
                })">
                    @csrf
                    @method('PUT')

                    <div class="mb-6 pb-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $verklaring->naam }}</h3>
                        <p class="text-sm text-gray-600">{{ $verklaring->adres }}, {{ $verklaring->postcode }} {{ $verklaring->stad }}</p>
                    </div>

                    <div class="mb-6" x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="flex items-center justify-between w-full text-left">
                            <h3 class="text-lg font-medium text-gray-900">Algemene Gegevens</h3>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" x-collapse class="mt-4">
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

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <x-input-label for="installateur" value="Installateur (optioneel)" />
                                    <x-text-input id="installateur" name="installateur" type="text" class="mt-1 block w-full" :value="old('installateur', $verklaring->installateur)" placeholder="Naam van de installateur" />
                                    <x-input-error :messages="$errors->get('installateur')" class="mt-1" />
                                </div>
                                <div>
                                    <x-input-label for="installateur_telefoon" value="Telefoon installateur" />
                                    <x-text-input id="installateur_telefoon" name="installateur_telefoon" type="text" class="mt-1 block w-full" :value="old('installateur_telefoon', $verklaring->installateur_telefoon)" placeholder="Telefoonnummer" />
                                    <x-input-error :messages="$errors->get('installateur_telefoon')" class="mt-1" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Groepen Indeling</h3>
                        <p class="text-sm text-gray-600 mb-4">Druk op enter om een tag toe te voegen. Sleep tags tussen groepen.</p>

                        <div class="border border-gray-300 rounded-lg overflow-hidden">
                            {{-- Header --}}
                            <div class="grid grid-cols-[64px_1fr] bg-gray-100 text-sm font-semibold">
                                <div class="px-3 py-2 border-r border-gray-300">Groep</div>
                                <div class="px-3 py-2">Omschrijving</div>
                            </div>

                            {{-- Rows --}}
                            @for ($i = 1; $i <= $verklaring->aantal_groepen; $i++)
                                <div class="grid grid-cols-[64px_1fr] border-t border-gray-300 {{ $i % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                                    <div class="px-3 py-2 font-medium text-center text-sm border-r border-gray-300">{{ $i }}</div>
                                    <div class="px-1 py-1 overflow-hidden"
                                        data-groep-id="{{ $i }}"
                                        @mouseenter="hoverGroep = {{ $i }}"
                                        @mouseleave="if(!dragging) hoverGroep = null"
                                        :class="{ 'bg-blue-50': dragging && hoverGroep === {{ $i }} }">
                                        <div class="flex flex-wrap items-center gap-1 min-h-[32px]">
                                            <template x-for="(tag, index) in groepen[{{ $i }}].tags" :key="index">
                                                <span
                                                    class="inline-flex items-center bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded cursor-grab select-none transition-opacity duration-150 hover:bg-gray-300"
                                                    :class="{ 'opacity-30': dragging && dragging.fromGroep === {{ $i }} && dragging.tagIndex === index }"
                                                    data-tag
                                                    @mousedown.prevent="startDrag($event, {{ $i }}, index, tag)"
                                                    @touchstart.prevent="startDrag($event, {{ $i }}, index, tag)">
                                                    <span x-text="tag"></span>
                                                    <button type="button" @click.stop="groepen[{{ $i }}].tags.splice(index, 1)" class="ml-1 text-gray-500 hover:text-gray-700">&times;</button>
                                                </span>
                                            </template>
                                            <input
                                                type="text"
                                                x-model="groepen[{{ $i }}].input"
                                                @keydown.enter.prevent="if(groepen[{{ $i }}].input.trim()) { groepen[{{ $i }}].tags.push(groepen[{{ $i }}].input.trim()); groepen[{{ $i }}].input = ''; }"
                                                @keydown.backspace="if(groepen[{{ $i }}].input === '' && groepen[{{ $i }}].tags.length > 0) { groepen[{{ $i }}].input = groepen[{{ $i }}].tags.pop(); }"
                                                class="flex-1 min-w-[100px] border-0 shadow-none bg-transparent focus:ring-0 text-sm p-1"
                                                placeholder="Type en druk enter..."
                                            />
                                        </div>
                                        <input type="hidden" name="groep_{{ $i }}" :value="[...groepen[{{ $i }}].tags, groepen[{{ $i }}].input.trim()].filter(t => t).join(' + ')">
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('verklaringen.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Terug</a>
                        <x-primary-button>Opslaan</x-primary-button>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form method="POST" action="{{ route('verklaringen.destroy', $verklaring) }}" @submit.prevent="if(confirm('Weet je zeker dat je deze verklaring wilt verwijderen?')) $el.submit()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Verklaring verwijderen
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
