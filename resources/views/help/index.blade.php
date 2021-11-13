<x-help-layout>

    <x-layout.box class="w-full">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
            <div class="flex flex-wrap items-center">
                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                    <h3 class="font-semibold text-base text-blueGray-700">
                        Introdução na central de ajuda
                    </h3>
                </div>
            </div>
        </div>

    </x-layout.box>

    <div class="rounded-t mb-0 px-4 py-3 border-0">
        <div class="block w-8/12 mx-auto overflow-x-auto">
            <p class="my-6">Nesta sessão do sistema você encontra tutoriais passo a passo de como realizar os principais processo do sistema</p>
            <p class="my-6">No lado esquerdo há a lista de módulos. Clicando em seus links você é redirecionado para a tela do tutorial deste módulo.
                Outro caminho é utilizar a lista abaixo:</p>
            <ul class="my-6">
                <li class="ml-8 my-2 list-disc"><a class="text-primary-500-dark" href="{{ route('help.users') }}">Usuários</a></li>
                <li class="ml-8 my-2 list-disc"><a class="text-primary-500-dark" href="{{ route('help.subjects') }}">Disciplinas</a></li>
                <li class="ml-8 my-2 list-disc"><a class="text-primary-500-dark" href="{{ route('help.lessons') }}">Aulas</a></li>
                <li class="ml-8 my-2 list-disc"><a class="text-primary-500-dark" href="{{ route('help.students_class') }}">Turmas</a></li>
                <li class="ml-8 my-2 list-disc"><a class="text-primary-500-dark" href="{{ route('help.works') }}">Trabalhos</a></li>
            </ul>
        </div>
    </div>

</x-help-layout>
