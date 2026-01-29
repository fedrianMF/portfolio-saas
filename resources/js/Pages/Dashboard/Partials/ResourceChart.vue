<template>
  <div class="bg-slate-900 border border-slate-800 rounded-lg p-6">
    <h3 class="text-slate-50 font-semibold mb-4 capitalize">{{ resourceType }} Usage</h3>

    <!-- Chart -->
    <div class="h-64 mb-6">
      <svg viewBox="0 0 600 250" class="w-full h-full">
        <!-- Grid lines -->
        <line x1="50" y1="30" x2="50" y2="200" stroke="#334155" stroke-width="2" />
        <line x1="50" y1="200" x2="580" y2="200" stroke="#334155" stroke-width="2" />

        <!-- Y-axis labels -->
        <text x="40" y="210" text-anchor="end" fill="#64748b" font-size="12">0%</text>
        <text x="40" y="155" text-anchor="end" fill="#64748b" font-size="12">50%</text>
        <text x="40" y="35" text-anchor="end" fill="#64748b" font-size="12">100%</text>

        <!-- Grid horizontal lines -->
        <line x1="50" y1="115" x2="580" y2="115" stroke="#1e293b" stroke-width="1" stroke-dasharray="5,5" />

        <!-- Area chart -->
        <path :d="areaPath" :fill="getColor()" opacity="0.2" />

        <!-- Line chart -->
        <polyline :points="linePath" fill="none" :stroke="getColor()" stroke-width="2" stroke-linejoin="round" />

        <!-- Data points -->
        <circle v-for="(point, idx) in chartPoints" :key="idx" :cx="point.x" :cy="point.y" :fill="getColor()" r="3" />

        <!-- X-axis labels -->
        <text v-for="(point, idx) in chartPoints" :key="`x-${idx}`" :x="point.x" y="220" text-anchor="middle"
          fill="#64748b" font-size="11">
          {{ data[idx].time }}
        </text>
      </svg>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-3 gap-4 pt-4 border-t border-slate-800">
      <div>
        <p class="text-slate-400 text-xs">Current</p>
        <p class="text-slate-50 font-mono text-lg">{{ data[data.length - 1].value }}%</p>
      </div>
      <div>
        <p class="text-slate-400 text-xs">Average</p>
        <p class="text-slate-50 font-mono text-lg">{{ average }}%</p>
      </div>
      <div>
        <p class="text-slate-400 text-xs">Peak</p>
        <p class="text-slate-50 font-mono text-lg">{{ peak }}%</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  resourceType: {
    type: String,
    required: true,
    validator: (value) => ['cpu', 'memory', 'disk'].includes(value)
  },
  data: {
    type: Array,
    required: true
  }
})

const chartPoints = computed(() => {
  const maxValue = 100
  const startX = 60
  const endX = 570
  const startY = 195
  const endY = 25
  const stepX = (endX - startX) / (props.data.length - 1)

  return props.data.map((point, idx) => ({
    x: startX + stepX * idx,
    y: startY - (point.value / maxValue) * (startY - endY)
  }))
})

const linePath = computed(() => {
  return chartPoints.value.map((point) => `${point.x},${point.y}`).join(' L ')
})

const areaPath = computed(() => {
  const points = chartPoints.value
  const startY = 200
  return `M ${points[0].x},${startY} L ${linePath.value} L ${points[points.length - 1].x},${startY} Z`
})

const average = computed(() => {
  const sum = props.data.reduce((acc, point) => acc + point.value, 0)
  return Math.round(sum / props.data.length)
})

const peak = computed(() => {
  return Math.max(...props.data.map((point) => point.value))
})

const getColor = () => {
  switch (props.resourceType) {
    case 'cpu':
      return '#8b5cf6' // indigo
    case 'memory':
      return '#06b6d4' // cyan
    case 'disk':
      return '#f59e0b' // amber
    default:
      return '#6b7280'
  }
}
</script>
