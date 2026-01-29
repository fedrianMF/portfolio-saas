<template>
  <header class="bg-slate-900 border-b border-slate-800">
    <div class="p-6">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold text-slate-50">System Dashboard</h1>
          <p class="text-slate-400 mt-1">Real-time system monitoring and management</p>
        </div>
        <div class="flex gap-4 items-center">
          <div class="text-right">
            <p class="text-slate-400 text-sm">Last updated</p>
            <p class="text-slate-50 font-mono text-sm">{{ currentTime }}</p>
          </div>
          <button @click="refreshData"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
            Refresh
          </button>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const currentTime = ref('')

const refreshData = () => {
  // Trigger refresh in parent component
  location.reload()
}

const updateTime = () => {
  const now = new Date()
  currentTime.value = now.toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  })
}

onMounted(() => {
  updateTime()
  setInterval(updateTime, 1000)
})
</script>
