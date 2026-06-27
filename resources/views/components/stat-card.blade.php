<div class="glass-panel card-hover p-5">
    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">{{ $label }}</p>
    <p class="mt-3 text-3xl font-bold text-zinc-100">{{ $value }}</p>
    @isset($meta)
        <p class="mt-2 text-xs text-slate-500">{{ $meta }}</p>
    @endisset
</div>
