<x-app>

    <x-layout.card-page title="Detalhes Trabalho">

        <div>
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Informações do trabalho</h6>

            <div class="flex flex-wrap">
                <div class="w-full lg:w-4/12 px-4">
                    <div class="relative w-full mb-3 text-blueGray-600">
                        <span class="block uppercase text-xs font-bold mb-2">Turma:</span>
                        <p class="border-0 px-3 py-3 rounded text-sm w-full">
                            {{ $work->studentsClass }}
                        </p>
                    </div>
                </div>

                <div class="w-full lg:w-4/12 px-4">
                    <div class="relative w-full mb-3 text-blueGray-600">
                        <span class="block uppercase text-xs font-bold mb-2">Aula:</span>
                        <p class="border-0 px-3 py-3 rounded text-sm w-full">
                            {{ $work->lesson->subject->description }}
                        </p>
                    </div>
                </div>

                <div class="w-full lg:w-4/12 px-4">
                    <div class="relative w-full mb-3 text-blueGray-600">
                        <span class="block uppercase text-xs font-bold mb-2">Prazo:</span>
                        <p class="border-0 px-3 py-3 rounded text-sm w-full">
                            {{ $work->deadline->format('d/m/Y H:i:s') }}
                        </p>
                    </div>
                </div>

                <div class="w-full px-4">
                    <div class="relative w-full mb-3 text-blueGray-600">
                        <span class="block uppercase text-xs font-bold mb-2">Título:</span>
                        <p class="border-0 px-3 py-3 rounded text-sm w-full">
                            {{ $work->title }}
                        </p>
                    </div>
                </div>
            </div>

            <hr class="mt-6 border-b-1 border-blueGray-300">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Conteúdo</h6>

            <div class="flex flex-wrap">
                <div class="w-full px-4">
                    <div class="relative w-full mb-3 text-blueGray-600">
                        <span class="block uppercase text-xs font-bold mb-2">Descrição:</span>
                        <p class="border-0 px-3 py-3 rounded text-sm w-full">
                            {{ $work->description }}
                        </p>
                    </div>
                </div>
            </div>

            @if($work->files->count() > 0)
            <div class="w-full px-4">
                <div class="relative w-full mb-3">
                    <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="">
                        Arquivos do Trabalho
                    </label>

                    <div class="border-0 px-3 py-5 mt-2 text-blueGray-500 bg-blueGray-50 rounded text-sm shadow w-full">
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($work->files as $file)
                                    <tr class="item-file">
                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                            <a target="_blank" href="{{ \Illuminate\Support\Facades\Storage::url($file->source) }}" class="text-blue-600">
                                                {{ $file->name }}
                                            </a>
                                        </th>
                                        <td class="w-14 border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                            {{ $file->type }}
                                        </td>
                                        <td class="w-14 border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                            {{ $file->size }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            @endif

        </div>

        @if(\Illuminate\Support\Facades\Auth::user()->type_of_user_id == \App\Support\Consts\TypeOfUsers::STUDENT)
        <hr class="mt-6 border-b-1 border-blueGray-300">
        <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Resposta</h6>

        <x-form.form action="{{ route('works.response', ['work' => $work->id]) }}" id="form-work" enctype="multipart/form-data">
            @if(\Illuminate\Support\Facades\Auth::user()->type_of_user_id == \App\Support\Consts\TypeOfUsers::STUDENT)

                <div class="w-full px-4">
                    <div class="relative w-full mb-3">
                        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="">
                            Arquivos da Resposta
                        </label>

                        <input type="file" class="hidden" name="files" id="files" multiple="multiple" />
                        <div id="box-input-file" class="border-0 border-transparent flex flex-col items-center justify-center px-3 py-5 h-32 text-blueGray-500 cursor-pointer bg-blueGray-50 rounded text-sm shadow w-full ease-linear transition-all duration-150">
                            Clique ou solte os arquivos aqui
                        </div>

                        @php
                            $response = $work->response(\Illuminate\Support\Facades\Auth::id())->first();
                        @endphp
                        <div id="table-files" class=" @if(is_null($response)) hidden @endif border-0 px-3 py-5 mt-2 text-blueGray-500 bg-blueGray-50 rounded text-sm shadow w-full">
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

                                @if(!is_null($response))
                                    @foreach($response->files as $file)
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

                                    @if($response->files->count() == 0)
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

            @endif
        </x-form.form>
        @endif
    </x-layout.card-page>

    <x-slot name="scripts">
        <script src="{{ asset('js/work.js') }}"></script>
    </x-slot>

</x-app>
