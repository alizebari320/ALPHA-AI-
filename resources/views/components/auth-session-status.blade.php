@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4 p-3 rounded-lg bg-cyan-500/10 text-cyan-400 text-sm font-medium text-center border border-cyan-500/30']) }}>
        {{ $status }}
    </div>
@endif
