<script setup>
import { Head, Link } from '@inertiajs/vue3';

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

        <main class="relative z-10 pt-20 pb-32">
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

            <!-- Dashboard Preview -->
            <div class="max-w-6xl mx-auto px-6 mt-24">
                <div
                    class="relative group p-1 rounded-3xl bg-gradient-to-br from-amber-500/30 via-slate-800/50 to-orange-500/30 shadow-2xl overflow-hidden transform hover:scale-[1.01] transition-all duration-700">
                    <div class="bg-slate-950 rounded-[22px] overflow-hidden border border-slate-800/50 p-2 md:p-4">
                        <img src="https://images.unsplash.com/photo-1551288049-bbbda546697a?auto=format&fit=crop&q=80&w=2070"
                            alt="Dashboard Preview" class="rounded-xl shadow-2xl" />

                        <!-- Overlay gradient for depth -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent pointer-events-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="max-w-7xl mx-auto px-6 mt-32 grid md:grid-cols-3 gap-8">
                <div v-for="(feature, i) in [
                    { title: 'Real-time Monitoring', desc: 'Track every performance metric with millisecond precision.', icon: 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' },
                    { title: 'Auto Scaling', desc: 'Scale your resources automatically based on demand surges.', icon: 'M13 10V3L4 14h7v7l9-11h-7z' },
                    { title: 'Security First', desc: 'Advanced protection against DDoS and malicious activities.', icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z' }
                ]" :key="i"
                    class="p-8 bg-slate-900/30 rounded-3xl border border-slate-800/50 hover:border-amber-500/30 transition-all hover:bg-slate-900/50 group">
                    <div
                        class="h-12 w-12 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-400 mb-6 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="feature.icon" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ feature.title }}</h3>
                    <p class="text-slate-400 leading-relaxed">{{ feature.desc }}</p>
                </div>
            </div>
        </main>

        <footer class="relative z-10 py-12 px-6 border-t border-slate-900 bg-slate-950/80 backdrop-blur-lg">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-slate-500 text-sm">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
                <div class="text-slate-500 text-sm">
                    © {{ new Date().getFullYear() }} Portfolio SaaS. Designed for the bold.
                </div>
                <div class="flex gap-6">
                    <a href="#" class="text-slate-500 hover:text-white transition-colors">Twitter</a>
                    <a href="#" class="text-slate-500 hover:text-white transition-colors">GitHub</a>
                </div>
            </div>
        </footer>
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
