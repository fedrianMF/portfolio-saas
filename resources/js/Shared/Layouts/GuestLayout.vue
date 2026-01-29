<script setup>
import ApplicationLogo from '@Shared/Components/Ui/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-slate-950 pt-6 sm:justify-center sm:pt-0 relative overflow-hidden">
        <!-- Background decorative elements -->
        <div
            class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[600px] h-[600px] bg-indigo-600/10 rounded-full blur-[120px] pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-purple-600/10 rounded-full blur-[120px] pointer-events-none">
        </div>

        <div class="z-10 mb-2">
            <Link href="/">
                <ApplicationLogo class="scale-150 transform" />
            </Link>
        </div>

        <div
            class="z-10 mt-6 w-full overflow-hidden bg-slate-900/50 backdrop-blur-xl px-8 py-10 border border-slate-800 shadow-2xl sm:max-w-md sm:rounded-3xl relative group">
            <!-- Subtle border glow -->
            <div
                class="absolute inset-0 rounded-3xl border border-indigo-500/20 pointer-events-none group-hover:border-indigo-500/40 transition-colors">
            </div>

            <slot />
        </div>

        <div class="z-10 mt-8 text-center">
            <p class="text-slate-500 text-sm">© {{ new Date().getFullYear() }} Portfolio SaaS. All rights reserved.</p>
        </div>
    </div>
</template>
