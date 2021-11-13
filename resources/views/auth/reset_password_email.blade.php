<x-guest>

    <main>
        <section class="absolute w-full h-full">
            <div
                class="absolute top-0 w-full h-full bg-gray-900"
                style="background-image: url({{ asset('images/register_bg_2.png') }}); background-size: 100%; background-repeat: no-repeat;"
            ></div>
            <div class="container mx-auto px-4 h-full">
                <div class="flex content-center items-center justify-center h-full">
                    <div class="w-full lg:w-4/12 px-4">
                        <div
                            class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0"
                        >
                            <div class="flex-auto px-4 lg:px-10 py-10">

                                <div class="w-full">
                                    <h1 class="text-center text-3xl mb-5">Elipse</h1>
                                    @error('email')
                                    <p class="text-red-600 mb-3 text-center text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                                <form action="{{ route('reset_password.send_email') }}" method="post">
                                    @csrf
                                    <div class="relative w-full mb-3">
                                        <label
                                            class="block uppercase text-gray-700 text-xs font-bold mb-2"
                                            for="email"
                                        >Email</label
                                        ><input
                                            type="email"
                                            name="email"
                                            id="email"
                                            class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full"
                                            placeholder="Email"
                                            style="transition: all 0.15s ease 0s;"
                                        />
                                    </div>
                                    <div class="flex flex-wrap items-end">
                                        <div class="w-full text-right">
                                            <a href="{{ route('login') }}" class="text-gray-800"
                                            ><small>Lembrou a senha?</small></a
                                            >
                                        </div>
                                    </div>
                                    <div class="text-center mt-6">
                                        <button
                                            class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                                            type="submit"
                                            style="transition: all 0.15s ease 0s;"
                                        >
                                            Recuperar senha
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-guest>
