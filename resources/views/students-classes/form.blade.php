<x-app>

    <x-layout.card-page title="Cadastrar nova aula">

        @php
            $studentsClass = $studentsClass ?? null;
            $route = $studentsClass ?  route('students_class.update', ['studentsClass' => $studentsClass->id]) : route('students_class.store');
        @endphp

        <x-form.form action="{{ $route }}" :model="$studentsClass">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Informações da aula</h6>

            <div class="flex flex-wrap">

                <x-form.input name="name" id="name" label="Nome" placeholder="Exemplo: A" width="w-full lg:w-4/12" required/>
                <x-form.select name="grade_id" :options="$grade" label="Série" value="value" width="w-full lg:w-4/12" required/>

            </div>

            <hr class="mt-6 border-b-1 border-blueGray-300">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Alunos</h6>

            <div class="flex flex-wrap">

                <div class="block w-5.5/12 overflow-x-auto px-4">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2">
                        Todos os alunos
                    </label>
                    <div id="list-all" class="border-0 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow w-full h-96">

                        @foreach($students as $student)
                            <button
                                type="button"
                                class="student text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent hover:bg-blue-100 text-blueGray-700 hover:shadow-sm text-left"
                                data-id="{{ $student->id }}"
                                data-list="all"
                                data-active="false"
                                @if(!is_null($studentsClass))
                                    style="{{ !$studentsClass->students->contains('id', $student->id) ?: 'display:none' }}"
                                @endif
                            >
                                {{ $student->name }}
                            </button>
                        @endforeach

                    </div>
                </div>

                <div class="w-1/12 flex flex-col content-center justify-center">
                    <div class="text-center">
                        <button
                            type="button"
                            class="bg-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none m-1 my-2 ease-linear transition-all duration-150"
                            id="add-class"
                        >
                            <i class="fas fa-arrow-right"></i>
                        </button>
                        <button
                            type="button"
                            class="bg-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none m-1 my-2 ease-linear transition-all duration-150"
                            id="remove-class"
                        >
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    </div>
                </div>


                <div class="block w-5.5/12 overflow-x-auto px-4">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2 required">
                        Alunos desta turma
                    </label>
                    <div id="list-class" class="border-0 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow w-full h-96">

                        @if(!is_null($studentsClass))
                            @foreach($studentsClass->students as $student)
                                <button
                                    type="button"
                                    class="student text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700 hover:bg-blue-100 hover:shadow-sm text-left"
                                    data-id="{{ $student->id }}"
                                >
                                    <input type="hidden" name="students[]" value="{{ $student->id }}">
                                    {{ $student->name }}
                                </button>
                            @endforeach
                        @endif

                    </div>
                    <div class="w-full">
                        <small class="text-red-600">
                            @error('students')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
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
    <script src="{{ asset('js/studentsClass.js') }}"></script>
</x-slot>
</x-app>
