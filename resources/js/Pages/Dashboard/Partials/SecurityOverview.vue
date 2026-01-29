<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Security Score -->
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
      <h3 class="text-slate-50 font-semibold mb-4">Security Score</h3>
      <div class="relative w-32 h-32 mx-auto">
        <svg class="w-full h-full" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="45" fill="none" stroke="#1e293b" stroke-width="8" />
          <circle cx="50" cy="50" r="45" fill="none" :stroke="getScoreColor(securityData.securityScore)"
            stroke-width="8" stroke-dasharray="282.7"
            :stroke-dashoffset="282.7 * (1 - securityData.securityScore / 100)" transform="rotate(-90 50 50)"
            class="transition-all duration-500" />
        </svg>
        <div class="absolute inset-0 flex items-center justify-center">
          <span class="text-3xl font-bold text-slate-50">{{ securityData.securityScore }}</span>
        </div>
      </div>
      <p class="text-center text-slate-400 text-sm mt-4">out of 100</p>
    </div>

    <!-- Blocked Requests -->
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
      <h3 class="text-slate-50 font-semibold mb-4">Blocked Requests</h3>
      <p class="text-4xl font-bold text-red-400 mb-2">{{ securityData.blockedRequests }}</p>
      <p class="text-slate-400 text-sm">in the last 24h</p>
      <div class="mt-4 pt-4 border-t border-slate-800">
        <div class="flex justify-between text-xs text-slate-400">
          <span>Malware attempts</span>
          <span class="text-slate-50">45</span>
        </div>
        <div class="flex justify-between text-xs text-slate-400 mt-2">
          <span>SQL Injection</span>
          <span class="text-slate-50">23</span>
        </div>
        <div class="flex justify-between text-xs text-slate-400 mt-2">
          <span>XSS attempts</span>
          <span class="text-slate-50">31</span>
        </div>
      </div>
    </div>

    <!-- Failed Logins -->
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
      <h3 class="text-slate-50 font-semibold mb-4">Failed Logins</h3>
      <p class="text-4xl font-bold text-amber-400 mb-2">{{ securityData.failedLogins }}</p>
      <p class="text-slate-400 text-sm">in the last 24h</p>
      <div class="mt-4 pt-4 border-t border-slate-800">
        <p class="text-slate-400 text-xs mb-2">Most active attacker</p>
        <p class="text-slate-50 font-mono text-sm">203.0.113.45</p>
      </div>
    </div>

    <!-- Active Sessions -->
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
      <h3 class="text-slate-50 font-semibold mb-4">Active Sessions</h3>
      <p class="text-4xl font-bold text-indigo-400 mb-2">{{ securityData.activeSessions }}</p>
      <p class="text-slate-400 text-sm">authenticated users</p>
      <div class="mt-4 pt-4 border-t border-slate-800">
        <div class="flex justify-between text-xs text-slate-400">
          <span>Admin users</span>
          <span class="text-slate-50">2</span>
        </div>
        <div class="flex justify-between text-xs text-slate-400 mt-2">
          <span>Regular users</span>
          <span class="text-slate-50">3</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  securityData: {
    type: Object,
    required: true
  }
})

const getScoreColor = (score) => {
  if (score >= 80) return '#10b981' // emerald
  if (score >= 60) return '#f59e0b' // amber
  return '#ef4444' // red
}
</script>
