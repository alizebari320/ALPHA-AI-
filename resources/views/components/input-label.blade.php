@props(['value'])

<label {{ $attributes->merge(['class' => 'al-field__label']) }}>
    {{ $value ?? $slot }}
</label>
