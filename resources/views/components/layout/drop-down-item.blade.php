@if(empty($href))
    <button
        type="button"
        {{ $attributes }}
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700 hover:bg-gray-100 text-left"
    >
        {{ $label }}
    </button>
@else
    <a
        href="{{ $href }}"
        {{ $attributes }}
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700 hover:bg-gray-100"
    >
        {{ $label }}
    </a>
@endif
