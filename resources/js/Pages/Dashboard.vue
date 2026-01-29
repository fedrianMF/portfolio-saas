<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    metrics: {
        type: Object,
        required: true,
    },
});

const getStatusColor = (percentage) => {
    if (percentage < 50) return 'bg-emerald-500';
    if (percentage < 75) return 'bg-amber-500';
    return 'bg-rose-500';
};
</script>

<template>
    <Head title="Infrastructure Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-bold leading-tight text-gray-800 dark:text-gray-200">
                Infrastructure Status
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                
                <!-- Welcome Section -->
                <div class="mb-6 overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Monitoring Active</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Real-time metrics from your VPS infrastructure.
                            <span class="ml-2 text-xs font-mono opacity-70">Last update: {{ metrics.timestamp }}</span>
                        </p>
                    </div>
                </div>

                <!-- Metrics Grid -->
                <div class="grid gap-6 md:grid-cols-2">
                    
                    <!-- CPU Widget -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 dark:bg-gray-800">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">CPU Load (1m)</h3>
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="flex items-end justify-between">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                {{ metrics.cpu }}
                            </span>
                            <span class="text-sm text-gray-500 mb-1">load avg</span>
                        </div>
                         <!-- Decorative generic bar since load isn't strictly 0-100% -->
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-4 dark:bg-gray-700">
                            <div class="bg-indigo-600 h-2.5 rounded-full" :style="{ width: Math.min(metrics.cpu * 20, 100) + '%' }"></div>
                        </div>
                    </div>

                    <!-- RAM Widget -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 dark:bg-gray-800">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Memory Usage</h3>
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        
                        <div class="flex items-end justify-between">
                            <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                {{ metrics.ram.percentage }}<span class="text-xl">%</span>
                            </span>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ metrics.ram.used_mb }} MB / {{ metrics.ram.total_mb }} MB</p>
                            </div>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-4 dark:bg-gray-700">
                            <div class="h-2.5 rounded-full transition-all duration-500" 
                                 :class="getStatusColor(metrics.ram.percentage)"
                                 :style="{ width: metrics.ram.percentage + '%' }"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
