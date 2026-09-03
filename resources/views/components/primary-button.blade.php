<button {{ $attributes->merge(['type' => 'submit', 'class' => 'al-btn al-btn--solid']) }}>
    {{ $slot }}
</button>
