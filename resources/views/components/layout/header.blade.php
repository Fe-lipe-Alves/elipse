<nav class="absolute top-0 left-0 w-full z-10 bg-primary-600 md:flex-row md:flex-nowrap md:justify-start flex items-center p-4">
    <div class="w-full mx-autp items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4">
        <span class="text-white text-sm uppercase hidden lg:inline-block font-semibold">
            Olá, {{ auth()->user()->name }}
        </span>

        <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
            <li class="inline-block relative mx-3">
                <a
                    class="text-white block py-1 px-3"
                    href="{{ route('messages.index') }}"
                    onclick="openDropdown(event,'notification-dropdown')"
                    title="Mensagens"
                >
                    <i class="fas fa-envelope"></i>
                </a>
            </li>
            <li>
                <a class="text-blueGray-500 block" href="#" id="userHeaderButton" data-hundle="dropdown" data-for="userHeaderBox">
                    <div class="items-center flex">
                  <span class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full">
                      <img alt="{{ auth()->user()->name }}" class="w-full rounded-full align-middle border-none shadow-lg" src="{{ asset('images/team-1-800x800.jpg') }}"/>
                  </span>
                    </div>
                </a>
            </li>
            <li class="inline-block relative mx-3">
                <a
                    class="text-white block py-1 px-3"
                    title="Opções"
                    href="#"
                    id="optionsHeaderButton"
                    data-hundle="dropdown"
                    data-for="optionsHeaderBox"
                >
                    <i class="fas fa-ellipsis-v"></i>
                </a>
            </li>
            <div
                class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1"
                style="min-width: 12rem;"
                id="userHeaderBox"
                data-interaction="dropdown"
            >
{{--                <a--}}
{{--                    href="#"--}}
{{--                    class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"--}}
{{--                >--}}
{{--                    Meu perfil--}}
{{--                </a>--}}
{{--                <div class="h-0 my-2 border border-solid border-blueGray-100"></div>--}}
                <a
                    href="#"
                    class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
                    id="logout"
                >
                    Sair
                    <x-form.form action="{{ route('logout') }}" class="hidden" id="formLogout"/>
                </a>
            </div>
            <div
                class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1"
                style="min-width: 12rem;"
                id="optionsHeaderBox"
                data-interaction="dropdown"
            >
                <a
                    href="{{ route('help') }}"
                    class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
                >
                    Ajuda
                </a>
                <a
                    href="#"
                    class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
                >
                    Feedback
                </a>
            </div>
        </ul>
    </div>
</nav>
