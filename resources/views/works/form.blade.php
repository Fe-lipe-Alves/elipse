<x-app>

    <x-layout.card-page title="Cadastrar novo trabalho">

        @php
            $work = $work ?? null;
            $route = $work ?  route('works.update', ['work' => $work->id]) : route('works.store');
        @endphp

        <x-form.form action="{{ $route }}" id="form-work" :model="$work" enctype="multipart/form-data">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Informações do trabalho</h6>

            <div class="flex flex-wrap">
                @if(auth()->user()->type_of_user_id != \App\Support\Consts\TypeOfUsers::TEACHER)

                <x-form.select name="students_class_id" label="Turma" width="w-full lg:w-4/12" required >
                    @if(is_null($work))
                        <x-form.option
                            value=""
                            description="Selecione"
                            selected disabled hidde
                        />
                    @else
                        @php($studentsClassID = $work->studentsClass()->first()->id)
                    @endif

                    @foreach($studentsClasses as $studentsClass)
                        <x-form.option
                            :value="$studentsClass->id"
                            :description="$studentsClass->description"
                            :data-teachers="route('students_class.teachers', ['studentsClass' => $studentsClass->id])"
                            :selected="($studentsClassID??false) == $studentsClass->id"
                        />
                    @endforeach

                </x-form.select>

                <x-form.select name="lesson_id" label="Aula" width="w-full lg:w-4/12 disabled:opacity-50" required>
                    @empty($lessons)
                        @foreach($lessons as $lesson)
                            <x-form.option
                                :value="$lesson->id"
                                :description="$lesson->subject->description"
                                :selected="$work->lesson_id == $lesson->id"
                            />
                        @endforeach
                    @endempty
                </x-form.select>
                @else
                    <x-form.select name="lesson_id" label="Aula" width="w-full lg:w-4/12 disabled:opacity-50" required>
                        @foreach($lessons as $lesson)
                            <x-form.option
                                :value="$lesson->id"
                                :description="$lesson->studentsClass->description"
                            />
                        @endforeach
                    </x-form.select>
                @endif

                <x-form.input type="datetime-local" :value="!is_null($work)?$work->deadline->format('Y-m-d\TH:i'):null" name="deadline" id="deadline" label="Prazo" width="w-full lg:w-4/12" required />

                <x-form.input name="title" id="title" label="Título" width="w-full" maxlength="150" required />

            </div>

            <hr class="mt-6 border-b-1 border-blueGray-300">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Conteúdo</h6>

            <x-form.textarea name="description" id="description" label="Descrição" rows="10" required>{{ is_null($work)?'':$work->description }}</x-form.textarea>

            <div class="w-full px-4">
                <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="">
                            Arquivos
                        </label>

                    <input type="file" class="hidden" name="files" id="files" multiple="multiple" />
                    <div id="box-input-file" class="border-0 border-transparent flex flex-col items-center justify-center px-3 py-5 h-32 text-blueGray-500 cursor-pointer bg-blueGray-50 rounded text-sm shadow w-full ease-linear transition-all duration-150">
                        Clique ou solte os arquivos aqui
                    </div>

                    <div id="table-files" class=" @if(is_null($work)) hidden @endif border-0 px-3 py-5 mt-2 text-blueGray-500 bg-blueGray-50 rounded text-sm shadow w-full">
                        <table class="items-center w-full bg-transparent border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                        Arquivo
                                    </th>
                                    <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                        Tipo
                                    </th>
                                    <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                        Tamanho
                                    </th>
                                    <th class="w-12 px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                        Remover
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($work))
                                    @foreach($work->files as $file)
                                        <tr class="item-file">
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                <a target="_blank" href="{{ \Illuminate\Support\Facades\Storage::url($file->source) }}">{{ $file->name }}</a>
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                {{ $file->type }}
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                {{ $file->size }}
                                            </td>
                                            <td class="w-12 border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">

                                                <button data-id="{{ $file->id }}" type="button" class="remove-file-uploaded bg-gray-200 text-black font-bold px-2 py-1 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"><i class="fas fa-minus"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($work->files->count() == 0)
                                        <tr class="item-file">
                                            <td colspan="4" class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">
                                                Não há arquivos
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @error('files')
                        <small class="text-red-600">
                            {{ $message }}
                        </small>
                    @enderror
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
    <script>
        const routes = {
            teachers: '{{ route('students_class.teachers', ['studentsClass' => 0]) }}'
        };
    </script>
    <script src="{{ asset('js/work.js') }}"></script>
</x-slot>
</x-app>
