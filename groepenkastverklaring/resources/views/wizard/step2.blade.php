<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Groepenkast Verklaring &mdash; Stap 2 van 2
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <p class="mb-6 text-gray-600">Vul per groep een omschrijving in (optioneel). Druk op enter om een tag toe te voegen. Sleep tags tussen groepen.</p>

                <form method="POST" action="{{ route('wizard.step2.store') }}" x-data="tagDragManager({
                    @foreach (range(1, $aantalGroepen) as $i)
                        {{ $i }}: { tags: [], input: '' },
                    @endforeach
                })">
                    @csrf

                    <div class="border border-gray-300 rounded-lg overflow-hidden">
                        {{-- Header --}}
                        <div class="grid grid-cols-[64px_1fr] bg-gray-100 text-sm font-semibold">
                            <div class="px-3 py-2 border-r border-gray-300">Groep</div>
                            <div class="px-3 py-2">Omschrijving</div>
                        </div>

                        {{-- Rows --}}
                        @foreach (range(1, $aantalGroepen) as $i)
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
                        @endforeach
                    </div>

                    <div class="flex justify-between mt-6">
                        <x-secondary-button @click="window.location='{{ route('wizard.step1') }}'">
                            &larr; Terug
                        </x-secondary-button>
                        <x-primary-button>
                            Opslaan
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>
