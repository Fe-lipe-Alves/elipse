<x-app>

    <x-layout.box class="w-full">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-base text-blueGray-700">
                        Aulas
                    </h3>
                </div>
                <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                    <a
                        class="bg-primary-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1"
                        type="button"
                        style="transition:all .15s ease"
                        href="{{ route('students_class.create') }}"
                    >
                        Novo
                    </a>
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
                    <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        Grau
                    </th>
                    <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        Alunos
                    </th>
                    <th class="w-1 px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">

                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($studentsClass as $studentsClass)
                    <tr>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
{{--                            {{ dd($studentsClass) }}--}}
                            {{ $studentsClass->grade->year }} {{ $studentsClass->grade->grade_type_id == 1 ? 'ano': 'série' }}
                            {{ $studentsClass->name }}
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                            {{ $studentsClass->grade->gradeType->description }}
                        </td>
                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                            {{ $studentsClass->students()->count() }}
                        </td>
                        <td class="w-1 border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                            <x-layout.dropdown :ref="$studentsClass->id">

                                <x-layout.dropdown-item
                                    :label="'Editar'"
                                    :href="route('students_class.edit', ['studentsClass' => $studentsClass->id])"
                                />

                                <x-layout.dropdown-item
                                    :label="'Apagar'"
                                    data-action="destroy"
                                    :data-route="route('students_class.destroy', ['studentsClass' => $studentsClass->id])"
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
