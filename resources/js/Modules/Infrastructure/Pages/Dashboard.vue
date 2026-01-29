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

<script setup>
import { ref, onMounted } from 'vue'
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

const healthData = ref({
  vps: { status: 'healthy', cpu: 34, memory: 62, uptime: '45d' },
  postgresql: { status: 'healthy', connections: 24, qps: 1240, uptime: '45d' },
  redis: { status: 'healthy', memory: 512, evictions: 0, uptime: '45d' },
  queue: { status: 'warning', failedJobs: 3, activeWorkers: 8, uptime: '2d' }
})

const securityData = ref({
  securityScore: 87,
  blockedRequests: 342,
  failedLogins: 12,
  activeSessions: 5
})

const cpuData = ref([
  { time: '00:00', value: 34 }, { time: '04:00', value: 28 }, { time: '08:00', value: 45 },
  { time: '12:00', value: 52 }, { time: '16:00', value: 48 }, { time: '20:00', value: 34 }
])

const memoryData = ref([
  { time: '00:00', value: 62 }, { time: '04:00', value: 65 }, { time: '08:00', value: 72 },
  { time: '12:00', value: 78 }, { time: '16:00', value: 74 }, { time: '20:00', value: 62 }
])

const diskData = ref([
  { time: '00:00', value: 45 }, { time: '04:00', value: 46 }, { time: '08:00', value: 48 },
  { time: '12:00', value: 49 }, { time: '16:00', value: 50 }, { time: '20:00', value: 45 }
])

const databasePerformance = ref({
  queryLatency: [
    { percentile: 'p50', value: 12 }, { percentile: 'p95', value: 45 }, { percentile: 'p99', value: 120 }
  ],
  activeConnections: 24,
  connectionLimit: 100
})

const supervisorWorkers = ref([
  { name: 'queue-high', status: 'running', processes: 4, memory: '256 MB', uptime: '3d' },
  { name: 'queue-default', status: 'running', processes: 8, memory: '512 MB', uptime: '5d' },
  { name: 'queue-low', status: 'running', processes: 2, memory: '128 MB', uptime: '2d' },
  { name: 'scheduler', status: 'running', processes: 1, memory: '64 MB', uptime: '10d' }
])

const recentJobs = ref([
  { id: 1, name: 'SendEmail', status: 'success', duration: '125ms', timestamp: '2 mins ago' },
  { id: 2, name: 'ProcessImage', status: 'success', duration: '2.3s', timestamp: '5 mins ago' },
  { id: 3, name: 'GenerateReport', status: 'failed', duration: '5s', timestamp: '8 mins ago', retries: 1 },
  { id: 4, name: 'CleanupCache', status: 'success', duration: '890ms', timestamp: '12 mins ago' }
])

const cronTasks = ref([
  { name: 'Cleanup Ephemeral Users', schedule: '0 2 * * *', nextRun: '2 hours', lastRun: '24 hours ago', status: 'scheduled' },
  { name: 'Database Backup', schedule: '0 3 * * 0', nextRun: '1 day', lastRun: '7 days ago', status: 'scheduled' },
  { name: 'Analytics Report', schedule: '0 9 * * MON', nextRun: '3 days', lastRun: '7 days ago', status: 'scheduled' },
  { name: 'Cache Warmer', schedule: '*/15 * * * *', nextRun: '12 minutes', lastRun: '2 minutes ago', status: 'running' }
])

const activeSessions = ref([
  { id: 1, user: 'admin@company.com', loginTime: '2h ago', autoDeleteIn: '46 minutes', ip: '192.168.1.100' },
  { id: 2, user: 'dev@company.com', loginTime: '1h ago', autoDeleteIn: '1h 46min', ip: '192.168.1.101' },
  { id: 3, user: 'temp-user-123', loginTime: '30m ago', autoDeleteIn: '29 minutes 30s', ip: '192.168.1.102' }
])

const dockerContainers = ref([
  { id: 'web-01', name: 'web-app', status: 'running', image: 'laravel:8.0', memory: '512 MB', cpu: '34%', ports: ['80:80', '443:443'] },
  { id: 'db-01', name: 'postgres', status: 'running', image: 'postgres:14', memory: '2 GB', cpu: '12%', ports: ['5432:5432'] },
  { id: 'cache-01', name: 'redis', status: 'running', image: 'redis:7', memory: '256 MB', cpu: '8%', ports: ['6379:6379'] },
  { id: 'queue-01', name: 'queue-worker', status: 'running', image: 'laravel-worker:latest', memory: '256 MB', cpu: '22%', ports: [] }
])

const auditLogs = ref([
  { id: 1, type: 'access_denied', user: 'unknown', action: 'SSH login attempt', timestamp: '2 mins ago', ip: '203.0.113.45', status: 'blocked' },
  { id: 2, type: 'command', user: 'admin', action: 'Deployed v1.2.3', timestamp: '15 mins ago', ip: '192.168.1.50', status: 'success' },
  { id: 3, type: 'access_denied', user: 'attacker', action: 'Brute force attempt', timestamp: '1h ago', ip: '198.51.100.23', status: 'blocked' },
  { id: 4, type: 'command', user: 'dev', action: 'Database migration run', timestamp: '2h ago', ip: '192.168.1.51', status: 'success' }
])

onMounted(() => {
  // Poll for real-time updates from your Laravel backend
  setInterval(() => {
    // Example: fetch('/api/dashboard/status').then(...)
  }, 5000)
})
</script>

<style scoped>
/* Dark mode system dashboard styles */
</style>
