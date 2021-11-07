<x-app>

    <x-layout.box class="w-full">
        <div class="rounded-t mb-0 px-4 py-3 border-0 border-b">
            <div class="flex flex-wrap items-center">
                <div class="relative w-4/12">
                    <h3 class="font-semibold text-base text-blueGray-700">
                        Mensagens
                    </h3>
                </div>
                <div class="relative w-8/12">
                    <h3 id="receiver-title" class="font-semibold text-base text-blueGray-700 text-center">
                        Lucas Alves
                    </h3>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap">
            <div class="w-full lg:w-4/12 bg-white border-r overflow-auto" id="list" style="height: 70vh">
                <ul>
                    @for($i=0; $i<10; $i++)
                        <li
                            class="receiver-list-item text-blueGray-500 border-t-0 align-middle border-l-0 border-r-0 text-sm whitespace-nowrap px-4 py-2 hover:shadow hover:bg-white ease-linear transition-all duration-100"
                            data-id="{{ $i }}"
                        >
                            Felipe Alves
                            <br/>
                            <small>Aluno</small>
                        </li>
                    @endfor
                </ul>
            </div>

            <div class="w-full lg:w-8/12 bg-white shadow-inner overflow-auto flex flex-col" id="messages" style="height: 70vh">
                <div id="history" class="flex-1 w-full overflow-auto py-4">

                    @php($last = null)
                    @for($i=0; $i<50; $i++)
                        @php($send = rand(0,1) == 1)
                        <div class="w-full flex flex-col @if($send) items-end @endif">
                            <div class="w-8/12 px-4 py-2 ml-1 mr-2  rounded-lg shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150
                                    @if($send) bg-white @else bg-primary-500-light @endif
                                    @if($last == $send) mt-1 @else mt-3 @endif
                                ">
                                <p class="text-sm"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, delectus doloribus excepturi id nobis perspiciatis veniam! Et hic quidem sapiente?</p>
                                <small class="text-xxs @if($send) float-right @endif">25/10/2021 08:25:30</small>
                            </div>
                        </div>
                        @php($last = $send)
                    @endfor

                </div>
                <form action="{{ route('messages.send') }}" id="newMessage" class="w-full border-t p-2 flex bg-gray-100">
                    @csrf
                    <input type="hidden" name="receiver_id" id="receiver_id" />
                    <input type="file" class="hidden" name="files[]" id="files" multiple="multiple" />
                    <div class="flex-1" id="box-input-text">
                        <input
                            type="text"
                            id="text-new-message"
                            name="text"
                            placeholder="Digite aqui o texto da mensagem"
                            class="w-full border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring ease-linear transition-all duration-150"
                        />
                    </div>
                    <div class="flex-1 hidden overflow-ellipsis overflow-hidden whitespace-nowrap" id="box-files-name">
                        <p class="py-2 text-sm" title="">
                            <span id="length">3</span> arquivos selecionados:
                            <span id="files-name"></span>
                        </p>
                    </div>

                    <div class="">
                        <button
                            class="px-4 bg-white py-2 ml-2 mr-1 rounded-full shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                            title="Anexar arquivo"
                            id="btn-file"
                            type="button"
                        >
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <button
                            class="px-4 bg-white py-2 ml-1 mr-2 rounded-full shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                            title="Enviar mensagem"
                            id="btn-send"
                            disabled="disabled"
                            type="submit"
                        >
                            <i class="far fa-paper-plane" style="margin-left: -2px"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </x-layout.box>

<x-slot name="scripts">
    <script src="{{ asset('js/message.js') }}"></script>
</x-slot>

</x-app>
