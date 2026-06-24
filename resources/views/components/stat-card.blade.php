<div class="glass-panel card-hover p-5">
    <p class="text-sm text-slate-400">{{ $label }}</p>
    <p class="mt-3 text-3xl font-bold bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">{{ $value }}</p>
    @isset($meta)
        <p class="mt-2 text-xs text-slate-500">{{ $meta }}</p>
    @endisset
</div>
