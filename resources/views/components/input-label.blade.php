@props(['value'])

<label {{ $attributes->merge(['class' => 'a1-field__label']) }}>
    {{ $value ?? $slot }}
</label>
