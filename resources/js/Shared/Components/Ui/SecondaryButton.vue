<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type"
        class="inline-flex items-center rounded-xl border border-surface-border bg-surface-card/50 px-6 py-3 text-xs font-bold uppercase tracking-widest text-slate-300 transition duration-200 ease-in-out hover:bg-surface-border hover:text-white focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-2 disabled:opacity-25 shadow-sm backdrop-blur-sm transform hover:-translate-y-0.5">
        <slot />
    </button>
</template>
