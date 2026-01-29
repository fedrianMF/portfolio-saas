<template>
  <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-800 border-b border-slate-700">
          <tr>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Type</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">User</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Action</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">IP Address</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Status</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Timestamp</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="log in logs" :key="log.id"
            class="border-b border-slate-800 hover:bg-slate-800/50 transition-colors">
            <td class="px-6 py-4">
              <span :class="getTypeBadge(log.type)">{{ formatType(log.type) }}</span>
            </td>
            <td class="px-6 py-4">
              <span class="text-slate-50 font-mono">{{ log.user }}</span>
            </td>
            <td class="px-6 py-4">
              <div>
                <p class="text-slate-50">{{ log.action }}</p>
                <p class="text-slate-500 text-xs mt-1">ID: {{ log.id }}</p>
              </div>
            </td>
            <td class="px-6 py-4">
              <span class="text-slate-400 font-mono text-sm">{{ log.ip }}</span>
            </td>
            <td class="px-6 py-4">
              <span :class="getStatusBadge(log.status)">{{ log.status }}</span>
            </td>
            <td class="px-6 py-4 text-slate-400">
              <span class="font-mono text-sm">{{ log.timestamp }}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Audit Summary -->
    <div class="px-6 py-4 bg-slate-800/50 border-t border-slate-800 grid grid-cols-4 gap-4 text-sm">
      <div>
        <p class="text-slate-400 text-xs mb-1">Total Events</p>
        <p class="text-slate-50 font-semibold text-lg">{{ logs.length }}</p>
      </div>
      <div>
        <p class="text-slate-400 text-xs mb-1">Blocked Attempts</p>
        <p class="text-red-400 font-semibold text-lg">{{ blockedCount }}</p>
      </div>
      <div>
        <p class="text-slate-400 text-xs mb-1">Successful Actions</p>
        <p class="text-emerald-400 font-semibold text-lg">{{ successCount }}</p>
      </div>
      <div>
        <p class="text-slate-400 text-xs mb-1">Command Actions</p>
        <p class="text-indigo-400 font-semibold text-lg">{{ commandCount }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  logs: {
    type: Array,
    required: true
  }
})

const formatType = (type) => {
  return type
    .split('_')
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ')
}

const getTypeBadge = (type) => {
  const baseClass = 'px-2 py-1 rounded text-xs font-semibold'
  switch (type) {
    case 'access_denied':
      return `${baseClass} bg-red-500/20 text-red-400`
    case 'command':
      return `${baseClass} bg-indigo-500/20 text-indigo-400`
    case 'login':
      return `${baseClass} bg-emerald-500/20 text-emerald-400`
    case 'logout':
      return `${baseClass} bg-slate-500/20 text-slate-400`
    default:
      return `${baseClass} bg-slate-500/20 text-slate-400`
  }
}

const getStatusBadge = (status) => {
  const baseClass = 'px-2 py-1 rounded text-xs font-semibold'
  switch (status) {
    case 'success':
      return `${baseClass} bg-emerald-500/20 text-emerald-400`
    case 'blocked':
      return `${baseClass} bg-red-500/20 text-red-400`
    case 'warning':
      return `${baseClass} bg-amber-500/20 text-amber-400`
    default:
      return `${baseClass} bg-slate-500/20 text-slate-400`
  }
}

const blockedCount = computed(() => {
  return props.logs.filter((log) => log.status === 'blocked').length
})

const successCount = computed(() => {
  return props.logs.filter((log) => log.status === 'success').length
})

const commandCount = computed(() => {
  return props.logs.filter((log) => log.type === 'command').length
})
</script>
