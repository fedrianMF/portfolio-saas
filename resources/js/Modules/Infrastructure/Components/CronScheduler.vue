<template>
  <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-800 border-b border-slate-700">
          <tr>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Task Name</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Schedule (Cron)</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Next Run</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Last Run</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(task, idx) in cronTasks" :key="idx"
            class="border-b border-slate-800 hover:bg-slate-800/50 transition-colors">
            <td class="px-6 py-4">
              <span class="text-slate-50 font-mono">{{ task.name }}</span>
            </td>
            <td class="px-6 py-4">
              <code class="text-indigo-400 text-xs bg-slate-800 px-2 py-1 rounded">{{ task.schedule }}</code>
            </td>
            <td class="px-6 py-4 text-slate-400">
              <span class="font-mono text-sm">{{ task.nextRun }}</span>
            </td>
            <td class="px-6 py-4 text-slate-400">
              <span class="font-mono text-sm">{{ task.lastRun }}</span>
            </td>
            <td class="px-6 py-4">
              <span :class="getStatusBadge(task.status)">{{ task.status }}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
defineProps({
  cronTasks: {
    type: Array,
    required: true
  }
})

const getStatusBadge = (status) => {
  const baseClass = 'px-2 py-1 rounded text-xs font-semibold inline-block'
  switch (status) {
    case 'running':
      return `${baseClass} bg-indigo-500/20 text-indigo-400`
    case 'scheduled':
      return `${baseClass} bg-slate-500/20 text-slate-400`
    case 'failed':
      return `${baseClass} bg-red-500/20 text-red-400`
    default:
      return `${baseClass} bg-slate-500/20 text-slate-400`
  }
}
</script>
