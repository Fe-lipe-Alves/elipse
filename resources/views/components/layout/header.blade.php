<nav class="absolute top-0 left-0 w-full z-10 bg-primary-600 md:flex-row md:flex-nowrap md:justify-start flex items-center p-4">
    <div class="w-full mx-autp items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4">
        <span class="text-white text-sm uppercase hidden lg:inline-block font-semibold">
            Olá, {{ auth()->user()->name }}
        </span>
        {{--
        <form
            class="md:flex hidden flex-row flex-wrap items-center lg:ml-auto mr-3"
        >
            <div class="relative flex w-full flex-wrap items-stretch">
                <span
                    class="z-10 h-full leading-snug font-normal absolute text-center text-blueGray-300 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-3"
                ><i class="fas fa-search"></i
                    ></span>
                <input
                    type="text"
                    placeholder="Search here..."
                    class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm shadow outline-none focus:outline-none focus:ring w-full pl-10"
                />
            </div>
        </form>--}}

        <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
            <a class="text-blueGray-500 block" href="#" id="userHeaderButton" data-hundle="dropdown" data-for="userHeaderBox">
                <div class="items-center flex">
                  <span class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full">
                      <img alt="{{ auth()->user()->name }}" class="w-full rounded-full align-middle border-none shadow-lg" src="{{ asset('images/team-1-800x800.jpg') }}"/>
                  </span>
                </div>
            </a>

            <div
                class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1"
                style="min-width: 12rem;"
                id="userHeaderBox"
                data-interaction="dropdown"
            >
                <a
                    href="#"
                    class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
                >
                    Meu perfil
                </a>
                <a
                    href="#"
                    class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
                >
                    Notificações
                </a>
                <div class="h-0 my-2 border border-solid border-blueGray-100"></div>
                <a
                    href="#"
                    class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
                    id="logout"
                >
                    Sair
                    <x-form.form action="{{ route('logout') }}" class="hidden" id="formLogout"/>
                </a>
            </div>
        </ul>
    </div>
</nav>
