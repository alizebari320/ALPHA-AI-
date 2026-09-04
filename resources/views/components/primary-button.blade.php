<button {{ $attributes->merge(['type' => 'submit', 'class' => 'a1-btn a1-btn--accent']) }}>
    {{ $slot }}
</button>
