<button
    type="button"
    data-hundle="dropdown"
    data-for="order_dropdown_{{ $order }}"
>
    <i class="fas fa-ellipsis-v"></i>
</button>

<div
    class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg mt-1"
    style="min-width: 12rem;"
    id="order_dropdown_{{ $order }}"
    data-interaction="dropdown"
>
    @foreach($list as $label => $link)
    <a
        href="{{ $link }}"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
    >
        {{ $label }}
    </a>
    @endforeach
</div>
