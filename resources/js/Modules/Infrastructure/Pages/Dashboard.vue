<script setup>
import { onMounted } from 'vue'
import DashboardHeader from '../Components/DashboardHeader.vue'
import HealthOverview from '../Components/HealthOverview.vue'
import SecurityOverview from '../Components/SecurityOverview.vue'
import ResourceChart from '../Components/ResourceChart.vue'
import DatabasePerformance from '../Components/DatabasePerformance.vue'
import WorkerMonitor from '../Components/WorkerMonitor.vue'
import JobPipeline from '../Components/JobPipeline.vue'
import CronScheduler from '../Components/CronScheduler.vue'
import ActiveSessions from '../Components/ActiveSessions.vue'
import DockerContainers from '../Components/DockerContainers.vue'
import AuditLogs from '../Components/AuditLogs.vue'

const props = defineProps({
  healthData: Object,
  securityData: Object,
  cpuData: Array,
  memoryData: Array,
  diskData: Array,
  databasePerformance: Object,
  supervisorWorkers: Array,
  recentJobs: Array,
  cronTasks: Array,
  activeSessions: Array,
  dockerContainers: Array,
  auditLogs: Array,
})


onMounted(() => {
  // Poll for real-time updates from your Laravel backend
  setInterval(() => {
    // Example: fetch('/api/dashboard/status').then(...)
  }, 5000)
})
</script>

<template>
  <div class="min-h-screen bg-slate-950 text-slate-50">
    <!-- Header -->
    <DashboardHeader />

    <!-- Main Content -->
    <main class="p-6 space-y-8">
      <!-- Health Overview Section -->
      <section class="space-y-4">
        <h2 class="text-xl font-semibold text-slate-50">System Health</h2>
        <HealthOverview :health-data="healthData" />
      </section>

      <!-- Security Section -->
      <section class="space-y-4">
        <h2 class="text-xl font-semibold text-slate-50">Security & Monitoring</h2>
        <SecurityOverview :security-data="securityData" />
      </section>

      <!-- Resource Telemetry -->
      <section class="space-y-4">
        <h2 class="text-xl font-semibold text-slate-50">Resource Telemetry</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <ResourceChart resource-type="cpu" :data="cpuData" />
          <ResourceChart resource-type="memory" :data="memoryData" />
          <ResourceChart resource-type="disk" :data="diskData" />
          <DatabasePerformance :data="databasePerformance" />
        </div>
      </section>

      <!-- Execution Engine & Jobs -->
      <section class="space-y-4">
        <h2 class="text-xl font-semibold text-slate-50">Execution Engine</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <WorkerMonitor :workers="supervisorWorkers" />
          <JobPipeline :jobs="recentJobs" />
        </div>
      </section>

      <!-- Cron Scheduler -->
      <section class="space-y-4">
        <h2 class="text-xl font-semibold text-slate-50">Scheduled Tasks</h2>
        <CronScheduler :cron-tasks="cronTasks" />
      </section>

      <!-- Active Sessions -->
      <section class="space-y-4">
        <h2 class="text-xl font-semibold text-slate-50">Active Sessions & Ephemeral Users</h2>
        <ActiveSessions :sessions="activeSessions" />
      </section>

      <!-- Docker Containers -->
      <section class="space-y-4">
        <h2 class="text-xl font-semibold text-slate-50">Docker Containers</h2>
        <DockerContainers :containers="dockerContainers" />
      </section>

      <!-- Audit Logs -->
      <section class="space-y-4">
        <h2 class="text-xl font-semibold text-slate-50">Audit Logs</h2>
        <AuditLogs :logs="auditLogs" />
      </section>
    </main>
  </div>
</template>

<style scoped>
/* Dark mode system dashboard styles */
</style>
