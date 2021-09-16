<div class="{{ $width }} inline-block text-center mb-3">

    <div class="relative w-full mb-3">

        <input type="{{ $type }}"
               class="border-0 focus:outline-none focus:ring ease-linear transition-all duration-150 shadow focus:outline-none focus:ring"
               name="{{ $name }}"
               id="{{ $id }}"
               value="{{ $value }}"
            {{ $attributes->merge(['checked' => $checked]) }}
            {{ $attributes }}
        >

        <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="{{ $id }}">
            {{ $label }}
        </label>

        @error($name)
        <small class="text-red-600">
            {{ $message }}
        </small>
        @enderror
    </div>

</div>
