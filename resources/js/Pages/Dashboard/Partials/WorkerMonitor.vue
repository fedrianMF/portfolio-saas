<template>
  <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
    <h3 class="text-slate-50 font-semibold mb-4">Supervisor Workers</h3>

    <div class="space-y-3 max-h-96 overflow-y-auto">
      <div v-for="worker in workers" :key="worker.name"
        class="bg-slate-800/50 rounded p-4 hover:bg-slate-800 transition-colors">
        <div class="flex items-start justify-between mb-3">
          <div class="flex-1">
            <h4 class="text-slate-50 font-mono text-sm font-semibold">{{ worker.name }}</h4>
            <p class="text-slate-400 text-xs mt-1">{{ worker.processes }} processes • {{ worker.memory }}</p>
          </div>
          <span :class="getStatusBadge(worker.status)">{{ worker.status }}</span>
        </div>

        <div class="grid grid-cols-3 gap-2 text-xs text-slate-400">
          <div class="flex justify-between">
            <span>Memory:</span>
            <span class="text-slate-50 font-mono">{{ worker.memory }}</span>
          </div>
          <div class="flex justify-between">
            <span>Processes:</span>
            <span class="text-slate-50 font-mono">{{ worker.processes }}</span>
          </div>
          <div class="flex justify-between">
            <span>Uptime:</span>
            <span class="text-slate-50 font-mono">{{ worker.uptime }}</span>
          </div>
        </div>

        <!-- Status indicator -->
        <div class="mt-3 pt-3 border-t border-slate-700 flex items-center gap-2">
          <div :class="getStatusDot(worker.status)" class="w-2 h-2 rounded-full" />
          <span class="text-xs text-slate-400">{{ getStatusMessage(worker.status) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  workers: {
    type: Array,
    required: true
  }
})

const getStatusBadge = (status) => {
  const baseClass = 'px-2 py-1 rounded text-xs font-semibold'
  switch (status) {
    case 'running':
      return `${baseClass} bg-emerald-500/20 text-emerald-400`
    case 'stopping':
      return `${baseClass} bg-amber-500/20 text-amber-400`
    case 'stopped':
      return `${baseClass} bg-red-500/20 text-red-400`
    default:
      return `${baseClass} bg-slate-500/20 text-slate-400`
  }
}

const getStatusDot = (status) => {
  switch (status) {
    case 'running':
      return 'bg-emerald-500'
    case 'stopping':
      return 'bg-amber-500'
    case 'stopped':
      return 'bg-red-500'
    default:
      return 'bg-slate-500'
  }
}

const getStatusMessage = (status) => {
  switch (status) {
    case 'running':
      return 'All workers running normally'
    case 'stopping':
      return 'Workers shutting down'
    case 'stopped':
      return 'Workers are offline'
    default:
      return 'Unknown status'
  }
}
</script>
