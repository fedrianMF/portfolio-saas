<template>
  <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
    <h3 class="text-slate-50 font-semibold mb-4">Recent Jobs (Queue Activity)</h3>

    <div class="space-y-2 max-h-96 overflow-y-auto">
      <div v-for="job in jobs" :key="job.id" class="bg-slate-800/50 rounded p-3 hover:bg-slate-800 transition-colors">
        <div class="flex items-center justify-between mb-2">
          <div class="flex items-center gap-3 flex-1">
            <div :class="getStatusIcon(job.status)" class="w-2 h-2 rounded-full flex-shrink-0" />
            <div class="flex-1 min-w-0">
              <h4 class="text-slate-50 font-mono text-sm truncate">{{ job.name }}</h4>
              <p class="text-slate-500 text-xs">ID: {{ job.id }}</p>
            </div>
          </div>
          <span :class="getStatusBadge(job.status)" class="flex-shrink-0">
            {{ job.status }}
          </span>
        </div>

        <div class="flex items-center justify-between text-xs text-slate-400">
          <div class="flex gap-4">
            <span>Duration: <span class="text-slate-50 font-mono">{{ job.duration }}</span></span>
            <span v-if="job.retries" class="text-amber-400">Retries: {{ job.retries }}</span>
          </div>
          <span class="text-slate-500">{{ job.timestamp }}</span>
        </div>
      </div>
    </div>

    <!-- Queue Stats -->
    <div class="mt-6 pt-6 border-t border-slate-800 grid grid-cols-3 gap-4">
      <div>
        <p class="text-slate-400 text-xs mb-1">Success Rate</p>
        <p class="text-emerald-400 font-semibold text-lg">98.5%</p>
      </div>
      <div>
        <p class="text-slate-400 text-xs mb-1">Avg Duration</p>
        <p class="text-indigo-400 font-semibold text-lg">1.2s</p>
      </div>
      <div>
        <p class="text-slate-400 text-xs mb-1">Failed (24h)</p>
        <p class="text-red-400 font-semibold text-lg">3</p>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  jobs: {
    type: Array,
    required: true
  }
})

const getStatusIcon = (status) => {
  switch (status) {
    case 'success':
      return 'bg-emerald-500'
    case 'failed':
      return 'bg-red-500'
    case 'retrying':
      return 'bg-amber-500'
    default:
      return 'bg-indigo-500'
  }
}

const getStatusBadge = (status) => {
  const baseClass = 'px-2 py-1 rounded text-xs font-semibold'
  switch (status) {
    case 'success':
      return `${baseClass} bg-emerald-500/20 text-emerald-400`
    case 'failed':
      return `${baseClass} bg-red-500/20 text-red-400`
    case 'retrying':
      return `${baseClass} bg-amber-500/20 text-amber-400`
    default:
      return `${baseClass} bg-indigo-500/20 text-indigo-400`
  }
}
</script>
