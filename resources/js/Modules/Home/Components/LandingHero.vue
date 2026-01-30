<script setup>
import { Link } from '@inertiajs/vue3';
import LandingLivePreview from './LandingLivePreview.vue';

defineProps({
    healthData: Object,
    cpuData: Array,
    memoryData: Array,
});
</script>

<template>
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-6 text-center space-y-8">
        <div
            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-sm font-medium animate-fade-in">
            <span class="relative flex h-2 w-2">
                <span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            Now in open beta
        </div>

        <h1 class="text-5xl md:text-7xl font-black tracking-tight leading-tight md:leading-tight">
            Manage your <br class="hidden md:block" />
            <span
                class="bg-clip-text text-transparent bg-gradient-to-r from-amber-400 via-orange-400 to-amber-500">
                Entire Infrastructure
            </span>
        </h1>

        <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
            A powerful SaaS solution designed to monitor, scale, and secure your digital assets in real-time.
            Built for
            creators and developers.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
            <Link :href="route('register')"
                class="px-8 py-4 bg-brand-primary hover:brightness-110 text-slate-950 rounded-2xl font-bold text-lg transition-all shadow-xl shadow-amber-500/30 transform hover:-translate-y-1">
                Start for free
            </Link>
            <button
                class="px-8 py-4 bg-slate-900/50 hover:bg-slate-800 text-white border border-slate-800 rounded-2xl font-bold text-lg transition-all backdrop-blur-sm">
                View Demo
            </button>
        </div>
    </div>

    <!-- Dashboard Preview (Live Widget) -->
    <div class="max-w-5xl mx-auto px-6 mt-20">
        <div
            class="relative group p-1 rounded-3xl bg-gradient-to-br from-amber-500/30 via-slate-800/50 to-orange-500/30 shadow-2xl overflow-hidden transform hover:scale-[1.01] transition-all duration-700">
            <LandingLivePreview :health-data="healthData" :cpu-data="cpuData" :memory-data="memoryData" />
            
            <!-- Reflection/Glow Effect -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/20 via-transparent to-white/5 pointer-events-none"></div>
        </div>
    </div>
</template>

<style scoped>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 1s ease-out forwards;
}
</style>
