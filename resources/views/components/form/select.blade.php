<div class="{{ $width }} px-4">

    <div class="relative w-full mb-3">

        @if($label)
            <label
                class="block uppercase text-blueGray-600 text-xs font-bold mb-2
                    {{ $attributes->has('required') ? 'required' : '' }}"
                for="{{ $id ?? $name }}"
            >
                {{ $label }}
            </label>
        @endif

        <select
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
            name="{{ $name }}"
            id="{{ $id ?? $name }}"
            {{ $attributes }}
        >

            @foreach($options as $option)
                <option value="{{ $option->value }}" {{ $isSelected($option->value) ? 'selected="selected"' : '' }}>
                    {{ $option->description }}
                </option>
            @endforeach

        </select>

        @error($name)
        <small class="text-red-600">
            {{ $message }}
        </small>
        @enderror
    </div>

</div>
