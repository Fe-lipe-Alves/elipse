<x-help-layout>

    <x-layout.box class="w-full">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-base text-blueGray-700">
                        Usuários
                    </h3>
                </div>
            </div>
        </div>

    </x-layout.box>

    <div class="rounded-t mb-0 px-4 py-3 border-0">
        <div class="block w-8/12 mx-auto overflow-x-auto">
            <p class="my-6">
                Os cadastro de usuários alunos, professores, secretário ou administradores são feitos no mesmo
                formulário. Acessando a <a href="{{ route('users.create') }}">página de usuários</a>, você verá a seguinte tela:
            </p>
            <img src="{{ asset('images/help/users-index.png') }}" alt="Página inicial de Usuários" class="hover:shadow-md">
            <p class="my-6">No lado esquerdo há a lista de módulos. Clicando em seus links você é redirecionado para a tela do tutorial deste módulo.
                Outro caminho é utilizar a lista abaixo:</p>
        </div>
    </div>

</x-help-layout>
