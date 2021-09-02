<x-app>

    <x-layout.card-page title="Cadastrar novo usuário">

        <x-form.form action="{{ route('users.store') }}">

            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">Informações do usuário</h6>

            <div class="flex flex-wrap">
                <x-form.input name="name" id="name" width="w-full lg:w-6/12" label="Nome Completo" required/>

                <x-form.input name="email" type="email" id="email" width="w-full lg:w-6/12" label="E-mail" required/>
            </div>
            <div class="flex flex-wrap">
                <x-form.input name="phone" type="phone" id="phone" width="w-full lg:w-6/12" label="Telefone" required />

                <x-form.input name="birth_date" type="date" id="birth_date" width="w-full lg:w-6/12" label="Data de nascimento" required />
            </div>

            <hr class="mt-6 border-b-1 border-blueGray-300">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"> Informações do Perfil </h6>

            <div class="flex flex-wrap">
                <div class="w-full lg:w-12/12 flex justify-center px-4">
                    <x-form.input-radio name="type_of_user_id" id="tou_1" label="Aluno" value="1" width="w-2/12" required />
                    <x-form.input-radio name="type_of_user_id" id="tou_2" label="Professor" value="2" width="w-2/12" required />
                    <x-form.input-radio name="type_of_user_id" id="tou_3" label="Secretario" value="3" width="w-2/12" required />
                    <x-form.input-radio name="type_of_user_id" id="tou_4" label="Administrador" value="4" width="w-2/12" required />

                </div>
            </div>

            <div class="flex flex-wrap">
                <div id="input-ra" class="w-full lg:w-4/12">
                    <x-form.input name="ra" id="ra" width="w-full" label="RA" required/>
                </div>
                <div id="input-cpf" class="w-full lg:w-4/12 hidden">
                    <x-form.input name="cpf" id="cpf" width="w-full" label="CPF"/>
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
    <script src="{{ asset('js/user.js') }}"></script>
</x-slot>
</x-app>
