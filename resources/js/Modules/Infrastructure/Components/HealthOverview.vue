<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- VPS Card -->
    <div
      class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 hover:border-amber-500/30 transition-all hover:bg-slate-900/80 group">
      <div class="flex justify-between items-start mb-4">
        <h3 class="text-slate-50 font-semibold">VPS</h3>
        <span :class="getStatusBadge(healthData.vps.status)">
          {{ healthData.vps.status }}
        </span>
      </div>
      <div class="space-y-2 text-sm text-slate-400">
        <div class="flex justify-between">
          <span>CPU Usage:</span>
          <span class="text-slate-50 font-mono">{{ healthData.vps.cpu }}%</span>
        </div>
        <div class="flex justify-between">
          <span>Memory:</span>
          <span class="text-slate-50 font-mono">{{ healthData.vps.memory }}%</span>
        </div>
        <div class="flex justify-between">
          <span>Uptime:</span>
          <span class="text-slate-50 font-mono">{{ healthData.vps.uptime }}</span>
        </div>
      </div>
    </div>

    <!-- PostgreSQL Card -->
    <div
      class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 hover:border-amber-500/30 transition-all hover:bg-slate-900/80 group">
      <div class="flex justify-between items-start mb-4">
        <h3 class="text-slate-50 font-semibold">PostgreSQL</h3>
        <span :class="getStatusBadge(healthData.postgresql.status)">
          {{ healthData.postgresql.status }}
        </span>
      </div>
      <div class="space-y-2 text-sm text-slate-400">
        <div class="flex justify-between">
          <span>Connections:</span>
          <span class="text-slate-50 font-mono">{{ healthData.postgresql.connections }}/200</span>
        </div>
        <div class="flex justify-between">
          <span>Queries/sec:</span>
          <span class="text-slate-50 font-mono">{{ healthData.postgresql.qps }}</span>
        </div>
        <div class="flex justify-between">
          <span>Uptime:</span>
          <span class="text-slate-50 font-mono">{{ healthData.postgresql.uptime }}</span>
        </div>
      </div>
    </div>

    <!-- Redis Card -->
    <div
      class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 hover:border-amber-500/30 transition-all hover:bg-slate-900/80 group">
      <div class="flex justify-between items-start mb-4">
        <h3 class="text-slate-50 font-semibold">Redis</h3>
        <span :class="getStatusBadge(healthData.redis.status)">
          {{ healthData.redis.status }}
        </span>
      </div>
      <div class="space-y-2 text-sm text-slate-400">
        <div class="flex justify-between">
          <span>Memory:</span>
          <span class="text-slate-50 font-mono">{{ healthData.redis.memory }} MB</span>
        </div>
        <div class="flex justify-between">
          <span>Evictions:</span>
          <span class="text-slate-50 font-mono">{{ healthData.redis.evictions }}</span>
        </div>
        <div class="flex justify-between">
          <span>Uptime:</span>
          <span class="text-slate-50 font-mono">{{ healthData.redis.uptime }}</span>
        </div>
      </div>
    </div>

    <!-- Queue Workers Card -->
    <div
      class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 rounded-2xl p-6 hover:border-amber-500/30 transition-all hover:bg-slate-900/80 group">
      <div class="flex justify-between items-start mb-4">
        <h3 class="text-slate-50 font-semibold">Queue Workers</h3>
        <span :class="getStatusBadge(healthData.queue.status)">
          {{ healthData.queue.status }}
        </span>
      </div>
      <div class="space-y-2 text-sm text-slate-400">
        <div class="flex justify-between">
          <span>Active Workers:</span>
          <span class="text-slate-50 font-mono">{{ healthData.queue.activeWorkers }}</span>
        </div>
        <div class="flex justify-between">
          <span>Failed Jobs:</span>
          <span class="text-red-400 font-mono">{{ healthData.queue.failedJobs }}</span>
        </div>
        <div class="flex justify-between">
          <span>Uptime:</span>
          <span class="text-slate-50 font-mono">{{ healthData.queue.uptime }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  healthData: {
    type: Object,
    required: true
  }
})

const getStatusBadge = (status) => {
  const baseClass = 'px-2 py-1 rounded text-xs font-semibold'
  switch (status) {
    case 'healthy':
      return `${baseClass} bg-emerald-500/20 text-emerald-400`
    case 'warning':
      return `${baseClass} bg-amber-500/20 text-amber-400`
    case 'critical':
      return `${baseClass} bg-red-500/20 text-red-400`
    default:
      return `${baseClass} bg-slate-500/20 text-slate-400`
  }
}
</script>
