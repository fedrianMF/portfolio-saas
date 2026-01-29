<template>
  <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-800 border-b border-slate-700">
          <tr>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Container</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Image</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Status</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Memory</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">CPU</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Ports</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="container in containers" :key="container.id"
            class="border-b border-slate-800 hover:bg-slate-800/50 transition-colors">
            <td class="px-6 py-4">
              <div>
                <p class="text-slate-50 font-mono font-semibold">{{ container.name }}</p>
                <p class="text-slate-500 text-xs mt-1">{{ container.id.substring(0, 12) }}</p>
              </div>
            </td>
            <td class="px-6 py-4 text-slate-400">
              <span class="font-mono text-xs">{{ container.image }}</span>
            </td>
            <td class="px-6 py-4">
              <span :class="getStatusBadge(container.status)">{{ container.status }}</span>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <div class="w-20 h-2 bg-slate-800 rounded-full overflow-hidden">
                  <div class="h-full bg-cyan-500 rounded-full"
                    :style="{ width: getMemoryPercent(container.memory) + '%' }" />
                </div>
                <span class="text-slate-50 font-mono text-xs">{{ container.memory }}</span>
              </div>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <div class="w-20 h-2 bg-slate-800 rounded-full overflow-hidden">
                  <div class="h-full bg-purple-500 rounded-full" :style="{ width: parseInt(container.cpu) + '%' }" />
                </div>
                <span class="text-slate-50 font-mono text-xs">{{ container.cpu }}</span>
              </div>
            </td>
            <td class="px-6 py-4">
              <div class="flex flex-wrap gap-1">
                <span v-for="(port, idx) in container.ports" :key="idx"
                  class="px-2 py-1 bg-slate-800 text-indigo-400 rounded text-xs font-mono">
                  {{ port }}
                </span>
                <span v-if="container.ports.length === 0" class="text-slate-500 text-xs">—</span>
              </div>
            </td>
            <td class="px-6 py-4">
              <div class="flex gap-2">
                <button @click="restartContainer(container.id)"
                  class="px-2 py-1 text-xs rounded bg-indigo-500/20 text-indigo-400 hover:bg-indigo-500/30 transition-colors">
                  Restart
                </button>
                <button @click="stopContainer(container.id)"
                  class="px-2 py-1 text-xs rounded bg-red-500/20 text-red-400 hover:bg-red-500/30 transition-colors">
                  Stop
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Container Stats Summary -->
    <div class="px-6 py-4 bg-slate-800/50 border-t border-slate-800 grid grid-cols-4 gap-4 text-sm">
      <div>
        <p class="text-slate-400 text-xs mb-1">Total Containers</p>
        <p class="text-slate-50 font-semibold text-lg">{{ containers.length }}</p>
      </div>
      <div>
        <p class="text-slate-400 text-xs mb-1">Running</p>
        <p class="text-emerald-400 font-semibold text-lg">{{ runningCount }}</p>
      </div>
      <div>
        <p class="text-slate-400 text-xs mb-1">Total Memory</p>
        <p class="text-slate-50 font-semibold text-lg">{{ totalMemory }}</p>
      </div>
      <div>
        <p class="text-slate-400 text-xs mb-1">Avg CPU</p>
        <p class="text-slate-50 font-semibold text-lg">{{ avgCpu }}%</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  containers: {
    type: Array,
    required: true
  }
})

const getStatusBadge = (status) => {
  const baseClass = 'px-2 py-1 rounded text-xs font-semibold'
  switch (status) {
    case 'running':
      return `${baseClass} bg-emerald-500/20 text-emerald-400`
    case 'stopped':
      return `${baseClass} bg-red-500/20 text-red-400`
    case 'paused':
      return `${baseClass} bg-amber-500/20 text-amber-400`
    default:
      return `${baseClass} bg-slate-500/20 text-slate-400`
  }
}

const getMemoryPercent = (memory) => {
  const match = memory.match(/(\d+)\s*([GM]?B?)/)
  if (!match) return 0

  const value = parseInt(match[1])
  const unit = match[2] || 'MB'

  // Assume max 4GB total memory for visualization
  const memoryInMB = unit === 'GB' ? value * 1024 : value
  return Math.min(100, (memoryInMB / 4096) * 100)
}

const runningCount = computed(() => {
  return props.containers.filter((c) => c.status === 'running').length
})

const totalMemory = computed(() => {
  const total = props.containers.reduce((acc, c) => {
    const match = c.memory.match(/(\d+)\s*([GM]?B?)/)
    if (!match) return acc

    const value = parseInt(match[1])
    const unit = match[2] || 'MB'
    return acc + (unit === 'GB' ? value * 1024 : value)
  }, 0)

  return total > 1024 ? (total / 1024).toFixed(1) + ' GB' : total + ' MB'
})

const avgCpu = computed(() => {
  const total = props.containers.reduce((acc, c) => acc + parseInt(c.cpu), 0)
  return Math.round(total / props.containers.length)
})

const restartContainer = (containerId) => {
  console.log('Restarting container:', containerId)
  // router.post(`/containers/${containerId}/restart`)
}

const stopContainer = (containerId) => {
  console.log('Stopping container:', containerId)
  // router.post(`/containers/${containerId}/stop`)
}
</script>
