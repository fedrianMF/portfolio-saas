<script setup>
</script>

<template>
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
</template>
