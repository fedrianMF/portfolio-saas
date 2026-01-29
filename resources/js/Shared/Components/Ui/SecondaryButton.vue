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
        class="inline-flex items-center rounded-xl border border-slate-700 bg-slate-800/50 px-6 py-3 text-xs font-bold uppercase tracking-widest text-slate-300 transition duration-200 ease-in-out hover:bg-slate-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 shadow-sm backdrop-blur-sm transform hover:-translate-y-0.5">
        <slot />
    </button>
</template>
