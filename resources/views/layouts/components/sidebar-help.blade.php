<nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6"
>
    <div
        class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto"
    >
        <button
            class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
            type="button"
            onclick="toggleNavbar('example-collapse-sidebar')"
        >
            <i class="fas fa-bars"></i></button
        >
        <a
            class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
            href="{{ route('home') }}"
        >
            Ajuda - {{ config('app.name') }}
        </a>
        <div
            class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded hidden"
            id="example-collapse-sidebar"
        >
            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="items-center">
                    <a
                        class="text-primary-500 hover:text-primary-600 text-xs uppercase py-3 font-bold block"
                        href="{{ route('help') }}"
                    >
                        Introdução</a
                    >
                </li>
            </ul>
            <hr class="my-4 md:min-w-full"/>

            <h6
                class="md:min-w-full text-blueGray-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
            >
                Cadastros
            </h6>
            <ul class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4">
                <x-layout.sidebar-item href="{{ route('help.users') }}" name="Usuários" icon="" />
                <x-layout.sidebar-item href="{{ route('help.subjects') }}" name="Disciplinas" icon="" />
                <x-layout.sidebar-item href="{{ route('help.lessons') }}" name="Aulas" icon="" />
                <x-layout.sidebar-item href="{{ route('help.students_class') }}" name="Turmas" icon="" />
            </ul>


            <hr class="my-4 md:min-w-full"/>

            <h6
                class="md:min-w-full text-blueGray-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
            >
                Acadêmico
            </h6>
            <ul class="md:flex-col md:min-w-full flex flex-col list-none md:mb-4">
                <x-layout.sidebar-item href="{{ route('help.works') }}" name="Trabalhos" icon="" />
            </ul>
        </div>
    </div>
</nav>
