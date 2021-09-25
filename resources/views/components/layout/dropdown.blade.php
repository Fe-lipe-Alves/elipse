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
    {{ $slot }}
</div>
