<template>
  <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
    <div class="mb-6">
      <h3 class="text-slate-50 font-semibold mb-2">Database Performance</h3>
      <p class="text-slate-400 text-sm">PostgreSQL query latency percentiles</p>
    </div>

    <!-- Latency Bars -->
    <div class="space-y-4 mb-6">
      <div v-for="percentile in data.queryLatency" :key="percentile.percentile">
        <div class="flex justify-between mb-2">
          <span class="text-slate-50 font-mono text-sm">{{ percentile.percentile }}</span>
          <span class="text-slate-50 font-mono text-sm">{{ percentile.value }}ms</span>
        </div>
        <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
          <div class="h-full bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full"
            :style="{ width: (percentile.value / 150) * 100 + '%' }" />
        </div>
      </div>
    </div>

    <!-- Connection Stats -->
    <div class="grid grid-cols-2 gap-4 pt-6 border-t border-slate-800">
      <div>
        <p class="text-slate-400 text-xs mb-1">Active Connections</p>
        <div class="flex items-baseline gap-2">
          <p class="text-slate-50 font-mono text-2xl">{{ data.activeConnections }}</p>
          <p class="text-slate-500 text-sm">/ {{ data.connectionLimit }}</p>
        </div>
        <div class="w-full bg-slate-800 rounded-full h-2 mt-2">
          <div class="h-full bg-emerald-500 rounded-full"
            :style="{ width: (data.activeConnections / data.connectionLimit) * 100 + '%' }" />
        </div>
      </div>
      <div>
        <p class="text-slate-400 text-xs mb-1">Connection Health</p>
        <p class="text-emerald-400 font-semibold text-lg">Healthy</p>
        <p class="text-slate-500 text-xs mt-2">{{ utilization }}% utilized</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  data: {
    type: Object,
    required: true
  }
})

const utilization = computed(() => {
  return Math.round((props.data.activeConnections / props.data.connectionLimit) * 100)
})
</script>
