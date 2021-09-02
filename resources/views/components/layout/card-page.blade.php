<div
    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0"
>
    <div class="rounded-t bg-white mb-0 px-6 py-4">
        <div class="text-center flex justify-between">
            <h6 class="text-blueGray-700 text-lg font-bold">{{ $title }}</h6>
            @isset($rightHeader)
                {{ $rightHeader }}
            @endisset
        </div>
    </div>
    <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
        {{ $slot }}
    </div>
</div>
