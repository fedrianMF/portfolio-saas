<script setup>
defineProps({
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
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
</template>
