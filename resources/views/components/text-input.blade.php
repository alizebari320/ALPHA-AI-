@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'tech-input']) }}>
