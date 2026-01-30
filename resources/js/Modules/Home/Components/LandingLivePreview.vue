<script setup>
import ResourceChart from '../../Infrastructure/Components/ResourceChart.vue';
import HealthOverview from '../../Infrastructure/Components/HealthOverview.vue';

defineProps({
    healthData: Object,
    cpuData: Array,
    memoryData: Array,
});
</script>

<template>
    <div class="bg-slate-950 rounded-xl overflow-hidden border border-slate-800/50 shadow-2xl relative">
        <!-- Dashboard Header Mockup -->
        <div class="h-12 border-b border-slate-800 flex items-center px-4 gap-4 bg-slate-900/50">
            <div class="flex gap-2">
                <div class="w-3 h-3 rounded-full bg-red-500/20 border border-red-500/50"></div>
                <div class="w-3 h-3 rounded-full bg-amber-500/20 border border-amber-500/50"></div>
                <div class="w-3 h-3 rounded-full bg-emerald-500/20 border border-emerald-500/50"></div>
            </div>
            <div class="h-6 w-32 bg-slate-800/50 rounded-md"></div>
        </div>

        <!-- Reused Dashboard Components -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-950/80">
            <!-- Health Overview -->
            <div class="md:col-span-2">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-2">System Status</p>
                <HealthOverview v-if="healthData" :health-data="healthData" />
            </div>

            <!-- Resource Charts -->
            <div>
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-2">CPU Usage (Live)</p>
                <ResourceChart v-if="cpuData" resource-type="cpu" :data="cpuData" />
            </div>
            
            <div>
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-2">Memory Usage (Live)</p>
                <ResourceChart v-if="memoryData" resource-type="memory" :data="memoryData" />
            </div>
        </div>

        <!-- Overlay Gradient for aesthetic integration -->
        <div class="absolute inset-0 pointer-events-none bg-gradient-to-t from-slate-950/40 via-transparent to-transparent"></div>
    </div>
</template>
