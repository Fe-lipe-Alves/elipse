<x-app>

    <x-layout.box class="w-full">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-base text-blueGray-700">
                        Trabalhos
                    </h3>
                </div>
                <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                    @if(auth()->user()->type_of_user_id != \App\Support\Consts\TypeOfUsers::STUDENT)
                        <a
                            class="bg-primary-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1"
                            type="button"
                            style="transition:all .15s ease"
                            href="{{ route('works.create') }}"
                        >
                            Novo
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="block w-full overflow-x-auto">
            <!-- Projects table -->
            <table class="items-center w-full bg-transparent border-collapse">
                <thead>
                <tr>
                    <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        Turma
                    </th>
                    <th class="flex-1 px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        Disciplina
                    </th>
                    <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        Título
                    </th>
                    <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        Prazo
                    </th>
                    <th class="w-1 px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">

                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($works as $work)
                    <tr>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                            {{ $work->studentsClass }}
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                            {{ $work->subject->description }}
                        </td>
                        <td class="w-5/12 max-w-lg overflow-ellipsis overflow-hidden border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                            {{ $work->title }}
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                            {{ $work->deadline->format('d/m/Y') }}
                        </td>
                        <td class="w-1 border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                            <x-layout.dropdown :ref="$work->id">

                                <x-layout.dropdown-item
                                    :label="'Editar'"
                                    :href="route('works.edit', ['work' => $work->id])"
                                />

                                <x-layout.dropdown-item
                                    :label="'Apagar'"
                                    data-action="destroy"
                                    :data-route="route('works.destroy', ['work' => $work->id])"
                                />

                            </x-layout.dropdown>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-layout.box>

</x-app>
