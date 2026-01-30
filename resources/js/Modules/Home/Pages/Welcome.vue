<script setup>
import { Head } from '@inertiajs/vue3';
import LandingHeader from '../Components/LandingHeader.vue';
import LandingHero from '../Components/LandingHero.vue';
import LandingFeatures from '../Components/LandingFeatures.vue';
import LandingFooter from '../Components/LandingFooter.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    // Data for Live Preview
    healthData: Object,
    cpuData: Array,
    memoryData: Array,
});
</script>

<template>

    <Head title="Welcome" />
    <div
        class="bg-slate-950 text-slate-50 min-h-screen relative overflow-hidden selection:bg-amber-500 selection:text-slate-950">
        <!-- Background mesh gradients -->
        <div
            class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[800px] h-[800px] bg-amber-500/10 rounded-full blur-[120px] pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-orange-500/10 rounded-full blur-[120px] pointer-events-none">
        </div>

        <LandingHeader :can-login="canLogin" :can-register="canRegister" />

        <main class="relative z-10 pt-20 pb-32">
            <LandingHero :health-data="healthData" :cpu-data="cpuData" :memory-data="memoryData" />
            <LandingFeatures />
        </main>

        <LandingFooter :laravel-version="laravelVersion" :php-version="phpVersion" />
    </div>
</template>
