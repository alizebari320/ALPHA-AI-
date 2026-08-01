<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-stone !bg-rose-600 !border-rose-600 !text-white hover:!bg-rose-500']) }}>
    {{ $slot }}
</button>
