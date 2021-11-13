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
                                    <p class="mb-3 text-center">{{ $message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-guest>
