<x-app>

    <x-layout.card-page title="Cadastrar nova disciplina">

        @php
            $subject = $subject ?? null;
            $route = $subject ?  route('subjects.update', ['subject' => $subject->id]) : route('subjects.store');
        @endphp

        <x-form.form action="{{ $route }}" :model="$subject">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Informações da disciplina</h6>

            <div class="flex flex-wrap">
                <x-form.input name="description" id="description" width="w-full lg:w-6/12" label="Descrição" required/>
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
    <script src="{{ asset('js/user.js') }}"></script>
</x-slot>
</x-app>
