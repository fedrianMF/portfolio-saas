<template>
  <div class="bg-slate-900 border border-slate-800 rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-800 border-b border-slate-700">
          <tr>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">User/Session</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Login Time</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">IP Address</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Auto-Delete In</th>
            <th class="px-6 py-3 text-left text-slate-50 font-semibold">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="session in sessions" :key="session.id"
            class="border-b border-slate-800 hover:bg-slate-800/50 transition-colors">
            <td class="px-6 py-4">
              <div>
                <p class="text-slate-50 font-mono">{{ session.user }}</p>
                <p v-if="session.user.includes('temp')" class="text-amber-400 text-xs mt-1">Ephemeral User</p>
              </div>
            </td>
            <td class="px-6 py-4 text-slate-400">
              <span class="font-mono text-sm">{{ session.loginTime }}</span>
            </td>
            <td class="px-6 py-4 text-slate-400">
              <span class="font-mono text-sm">{{ session.ip }}</span>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <div class="w-24 h-2 bg-slate-800 rounded-full overflow-hidden">
                  <div class="h-full bg-gradient-to-r from-amber-500 to-red-500 rounded-full transition-all"
                    :style="{ width: calculateProgress(session.autoDeleteIn) + '%' }" />
                </div>
                <span class="text-amber-400 font-mono text-xs whitespace-nowrap">{{ session.autoDeleteIn }}</span>
              </div>
            </td>
            <td class="px-6 py-4">
              <button @click="terminateSession(session.id)"
                class="px-3 py-1 text-xs rounded bg-red-500/20 text-red-400 hover:bg-red-500/30 transition-colors">
                Terminate
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Legend -->
    <div class="px-6 py-4 bg-slate-800/50 border-t border-slate-800 text-xs text-slate-400">
      <p class="flex items-center gap-2">
        <span class="w-3 h-3 rounded-full bg-amber-500" />
        Ephemeral users are automatically deleted after 2 hours of inactivity. The countdown shows remaining time before
        auto-deletion.
      </p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  sessions: {
    type: Array,
    required: true
  }
})

const calculateProgress = (timeString) => {
  // Simple progress calculation based on time remaining
  const match = timeString.match(/(\d+)\s*(h|min)/)
  if (!match) return 50

  const value = parseInt(match[1])
  const unit = match[2]
  const totalMinutes = unit === 'h' ? value * 60 : value

  return Math.max(5, Math.min(95, (totalMinutes / 120) * 100))
}

const terminateSession = (sessionId) => {
  // Call API to terminate session
  console.log('Terminating session:', sessionId)
  // router.post(`/sessions/${sessionId}/terminate`)
}
</script>
