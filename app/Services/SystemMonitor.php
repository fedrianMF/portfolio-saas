<?php

namespace App\Services;

class SystemMonitor
{
    /**
     * Capture current system metrics.
     */
    public function getMetrics(): array
    {
        return [
            'cpu' => $this->getCpuUsage(),
            'ram' => $this->getMemoryUsage(),
            'timestamp' => now()->toIso8601String(),
        ];
    }

    protected function getCpuUsage(): float
    {
        // 1-minute load average
        $load = sys_getloadavg();
        return $load[0] ?? 0.0;
    }

    protected function getMemoryUsage(): array
    {
        // Read from /proc/meminfo
        $memInfo = @file_get_contents('/proc/meminfo');

        if (!$memInfo) {
            return [
                'total_mb' => 0,
                'used_mb' => 0,
                'percentage' => 0,
            ];
        }

        $data = [];
        foreach (explode("\n", $memInfo) as $line) {
            if (preg_match('/^(\w+):\s+(\d+)/', $line, $matches)) {
                $data[$matches[1]] = (int) $matches[2]; // Values are in kB
            }
        }

        $total = $data['MemTotal'] ?? 1;
        $available = $data['MemAvailable'] ?? ($data['MemFree'] ?? 0);
        $used = $total - $available;

        return [
            'total_mb' => round($total / 1024, 2),
            'used_mb' => round($used / 1024, 2),
            'percentage' => round(($used / $total) * 100, 2),
        ];
    }
}
