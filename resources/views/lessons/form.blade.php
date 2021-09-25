<x-app>

    <x-layout.card-page title="Cadastrar nova aula">

        @php
            $lesson = $lesson ?? null;
            $route = $lesson ?  route('lessons.update', ['lesson' => $lesson->id]) : route('lessons.store');
        @endphp

        <x-form.form action="{{ $route }}" :model="$lesson">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Informações da aula</h6>

            <div class="flex flex-wrap">

                <x-form.select name="subject_id" :options="$subjects" label="Disciplina" width="w-full lg:w-4/12" />
                <x-form.select name="teacher_id" :options="$teachers" label="Professor" description="name" width="w-full lg:w-4/12" />
                <x-form.select name="students_class_id" :options="$studentsClasses" label="Turma" width="w-full lg:w-4/12" />

            </div>

            <hr class="mt-6 border-b-1 border-blueGray-300">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Horários</h6>

            <div class="flex flex-wrap">
{{--                <div class="w-1/12 d-none d-md-block"></div>--}}
{{--                @for($i=1; $i<=5; $i++)--}}
{{--                    <div class="w-2/12 bg-teal-200">132</div>--}}
{{--                @endfor--}}
{{--                <div class="w-1/12 d-none d-md-block"></div>--}}

                <div class="block w-full overflow-x-auto">
                    <!-- Projects table -->
                    <table class="items-center w-full bg-white border-collapse">
                        <thead>
                        <tr>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                                Segunda
                            </th>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                                Terça
                            </th>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                                Quarta
                            </th>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                                Quinta
                            </th>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center">
                                Sexta
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 6; $i++)
                                <tr>
                                    @for($j = 1; $j <= 5; $j++)
                                        @php($checked = in_array(($i.'-'.$j), $schedules))
                                        <td
                                            data-selected="false"
                                            class="class_schedule-item text-center border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 {{ $checked ? 'bg-indigo-300 hover:bg-indigo-200' : 'hover:bg-indigo-100' }}"
                                        >
                                            <input
                                                type="checkbox"
                                                name="class_schedule[]"
                                                value="{{ $i.'-'.$j }}"
                                                style="display: none"
                                                {{ $checked ? 'checked="checked"' : '' }}
                                            />
                                            {{ $i }}° aula
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

            </div>

            <hr class="mt-6 border-b-1 border-blueGray-300">

            <div class="flex flex-wrap">
                <div class="w-full lg:w-12/12 px-4">
                    <div class="relative w-full text-center py-6 mb-3">
                        <button
                            class="bg-primary-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                            type="submit"
                        >
                            Salvar
                        </button>
                    </div>
                </div>
            </div>

        </x-form.form>

    </x-layout.card-page>

<x-slot name="scripts">
    <script src="{{ asset('js/lesson.js') }}"></script>
</x-slot>
</x-app>
