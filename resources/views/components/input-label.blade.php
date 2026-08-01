@props(['value'])

<label {{ $attributes->merge(['class' => 'tech-label']) }}>
    {{ $value ?? $slot }}
</label>
