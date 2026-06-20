<div class="glass-panel card-hover p-5">
    <p class="text-sm text-slate-400">{{ $label }}</p>
    <p class="mt-3 text-3xl font-bold">{{ $value }}</p>
    @isset($meta)
        <p class="mt-2 text-xs text-slate-500">{{ $meta }}</p>
    @endisset
</div>
