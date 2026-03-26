<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Groepenkast Verklaring &mdash; Stap 2 van 2
        </h2>
    </x-slot>

    <style>
        .tag-item { cursor: pointer; user-select: none; }
        .tag-item:hover { background-color: #d1d5db; }
        .tag-ghost { position: fixed; pointer-events: none; z-index: 9999; opacity: 0.8; }
        body.dragging, body.dragging * { cursor: pointer !important; }
    </style>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <p class="mb-6 text-gray-600">Vul per groep een omschrijving in (optioneel). Druk op enter om een tag toe te voegen. Sleep tags tussen groepen.</p>

                <form method="POST" action="{{ route('wizard.step2.store') }}" x-data="tagDragManager()" x-init="init()">
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
                                        <td class="border border-gray-300 px-1 py-1"
                                            @mouseenter="hoverGroep = {{ $i }}"
                                            @mouseleave="hoverGroep = null"
                                            :class="{ 'bg-blue-50': dragging && dragging.fromGroep !== {{ $i }} && hoverGroep === {{ $i }} }">
                                            <div class="flex flex-wrap items-center gap-1 min-h-[32px]">
                                                <template x-for="(tag, index) in groepen[{{ $i }}].tags" :key="index">
                                                    <span
                                                        class="tag-item inline-flex items-center bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded"
                                                        @mousedown.prevent="startDrag($event, {{ $i }}, index, tag)">
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
                            Opslaan
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function tagDragManager() {
            return {
                groepen: {
                    @foreach (range(1, $aantalGroepen) as $i)
                        {{ $i }}: { tags: [], input: '' },
                    @endforeach
                },
                dragging: null,
                ghostEl: null,
                hoverGroep: null,

                init() {
                    this.boundMouseMove = this.onMouseMove.bind(this);
                    this.boundMouseUp = this.onMouseUp.bind(this);
                },

                startDrag(e, groepId, tagIndex, tag) {
                    this.dragging = { fromGroep: groepId, tagIndex: tagIndex, tag: tag };
                    document.body.classList.add('dragging');

                    this.ghostEl = document.createElement('span');
                    this.ghostEl.className = 'tag-ghost inline-flex items-center bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded';
                    this.ghostEl.textContent = tag;
                    this.ghostEl.style.left = (e.clientX + 10) + 'px';
                    this.ghostEl.style.top = (e.clientY + 10) + 'px';
                    document.body.appendChild(this.ghostEl);

                    document.addEventListener('mousemove', this.boundMouseMove);
                    document.addEventListener('mouseup', this.boundMouseUp);
                },

                onMouseMove(e) {
                    if (this.ghostEl) {
                        this.ghostEl.style.left = (e.clientX + 10) + 'px';
                        this.ghostEl.style.top = (e.clientY + 10) + 'px';
                    }
                },

                onMouseUp(e) {
                    document.removeEventListener('mousemove', this.boundMouseMove);
                    document.removeEventListener('mouseup', this.boundMouseUp);

                    if (this.ghostEl) {
                        this.ghostEl.remove();
                        this.ghostEl = null;
                    }

                    if (this.dragging && this.hoverGroep && this.dragging.fromGroep !== this.hoverGroep) {
                        this.groepen[this.hoverGroep].tags.push(this.dragging.tag);
                        this.groepen[this.dragging.fromGroep].tags.splice(this.dragging.tagIndex, 1);
                    }

                    document.body.classList.remove('dragging');
                    this.dragging = null;
                }
            }
        }
    </script>
</x-app-layout>
