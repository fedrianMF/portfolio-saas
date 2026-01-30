<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <nav
        class="sticky z-10 p-6 md:px-12 flex justify-between items-center bg-slate-950/50 backdrop-blur-md top-0 border-b border-slate-800/50">
        <div class="flex items-center gap-2">
            <div
                class="h-10 w-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-950" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span
                class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-amber-400 to-orange-500">Portfolio
                SaaS</span>
        </div>

        <div v-if="canLogin" class="flex items-center gap-4">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                class="px-5 py-2.5 bg-brand-primary hover:brightness-110 text-slate-950 rounded-xl font-bold transition-all shadow-lg shadow-amber-500/30">
                Go to Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')"
                    class="px-5 py-2.5 text-slate-300 hover:text-white font-medium transition-colors">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 rounded-xl font-medium transition-all">
                    Register
                </Link>
            </template>
        </div>
    </nav>
</template>
