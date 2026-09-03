@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'al-input']) }}>
