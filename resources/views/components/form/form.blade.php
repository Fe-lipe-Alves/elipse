<form action="{{ $action }}" method="{{ $method }}" {{ $attributes }}>
    @csrf

    @if(!is_null($model))
        @method('put')
    @endif

    {{ $slot }}

</form>
