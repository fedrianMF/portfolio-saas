<?php

namespace App\Services\Infrastructure;

class SystemMonitorService
{
    public function getSystemHealth(): array
    {
        return [
            'vps' => [
                'status' => 'healthy',
                'cpu' => $this->getCpuUsage(),
                'memory' => $this->getMemoryUsage(),
                'uptime' => $this->getUptime()
            ],
            'postgresql' => [
                'status' => 'healthy',
                'connections' => rand(20, 30),
                'qps' => rand(1000, 1500),
                'uptime' => '45d'
            ],
            'redis' => [
                'status' => 'healthy',
                'memory' => 512,
                'evictions' => 0,
                'uptime' => '45d'
            ],
            'queue' => [
                'status' => 'warning',
                'failedJobs' => rand(0, 5),
                'activeWorkers' => 8,
                'uptime' => '2d'
            ]
        ];
    }

    public function getSecurityMetrics(): array
    {
        return [
            'securityScore' => 87,
            'blockedRequests' => rand(300, 400),
            'failedLogins' => rand(5, 15),
            'activeSessions' => 5
        ];
    }

    public function getResourceTelemetry(): array
    {
        $times = ['00:00', '04:00', '08:00', '12:00', '16:00', date('H:i')];

        // Use real current value for the last point, mock history for now
        $currentCpu = $this->getCpuUsage();
        $currentMemory = $this->getMemoryUsage();
        $currentDisk = $this->getDiskUsage();

        return [
            'cpu' => array_map(
                fn($t, $i) =>
                ['time' => $t, 'value' => $i === count($times) - 1 ? $currentCpu : rand(20, 60)],
                $times,
                array_keys($times)
            ),
            'memory' => array_map(
                fn($t, $i) =>
                ['time' => $t, 'value' => $i === count($times) - 1 ? $currentMemory : rand(50, 80)],
                $times,
                array_keys($times)
            ),
            'disk' => array_map(
                fn($t, $i) =>
                ['time' => $t, 'value' => $i === count($times) - 1 ? $currentDisk : rand(40, 55)],
                $times,
                array_keys($times)
            ),
        ];
    }

    private function getCpuUsage(): int
    {
        // Simple accurate load for Linux
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return (int) ($load[0] * 10); // Rough approximation for demo, 1.0 load = ~10% visual
        }
        return 0;
    }

    private function getMemoryUsage(): int
    {
        if (file_exists('/proc/meminfo')) {
            $data = explode("\n", file_get_contents('/proc/meminfo'));
            $memTotal = $memAvailable = 0;
            foreach ($data as $line) {
                if (preg_match('/^MemTotal:\s+(\d+)\s+kB$/i', $line, $matches)) $memTotal = $matches[1];
                if (preg_match('/^MemAvailable:\s+(\d+)\s+kB$/i', $line, $matches)) $memAvailable = $matches[1];
            }
            if ($memTotal > 0) {
                return (int) ((($memTotal - $memAvailable) / $memTotal) * 100);
            }
        }
        return 0;
    }

    private function getDiskUsage(): int
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');
        return (int) ((($total - $free) / $total) * 100);
    }

    private function getUptime(): string
    {
        if (file_exists('/proc/uptime')) {
            $uptime = (int) explode(' ', file_get_contents('/proc/uptime'))[0];
            $days = floor($uptime / 86400);
            $hours = floor(($uptime % 86400) / 3600);
            return "{$days}d {$hours}h";
        }
        return '0d';
    }

    public function getDatabasePerformance(): array
    {
        return [
            'queryLatency' => [
                ['percentile' => 'p50', 'value' => rand(10, 15)],
                ['percentile' => 'p95', 'value' => rand(40, 60)],
                ['percentile' => 'p99', 'value' => rand(100, 150)]
            ],
            'activeConnections' => rand(20, 40),
            'connectionLimit' => 100
        ];
    }

    public function getWorkers(): array
    {
        return [
            ['name' => 'queue-high', 'status' => 'running', 'processes' => 4, 'memory' => '256 MB', 'uptime' => '3d'],
            ['name' => 'queue-default', 'status' => 'running', 'processes' => 8, 'memory' => '512 MB', 'uptime' => '5d'],
            ['name' => 'queue-low', 'status' => 'running', 'processes' => 2, 'memory' => '128 MB', 'uptime' => '2d'],
            ['name' => 'scheduler', 'status' => 'running', 'processes' => 1, 'memory' => '64 MB', 'uptime' => '10d']
        ];
    }

    public function getRecentJobs(): array
    {
        return [
            ['id' => 1, 'name' => 'SendEmail', 'status' => 'success', 'duration' => '125ms', 'timestamp' => '2 mins ago'],
            ['id' => 2, 'name' => 'ProcessImage', 'status' => 'success', 'duration' => '2.3s', 'timestamp' => '5 mins ago'],
            ['id' => 3, 'name' => 'GenerateReport', 'status' => 'failed', 'duration' => '5s', 'timestamp' => '8 mins ago', 'retries' => 1],
            ['id' => 4, 'name' => 'CleanupCache', 'status' => 'success', 'duration' => '890ms', 'timestamp' => '12 mins ago']
        ];
    }

    public function getCronTasks(): array
    {
        return [
            ['name' => 'Cleanup Ephemeral Users', 'schedule' => '0 2 * * *', 'nextRun' => '2 hours', 'lastRun' => '24 hours ago', 'status' => 'scheduled'],
            ['name' => 'Database Backup', 'schedule' => '0 3 * * 0', 'nextRun' => '1 day', 'lastRun' => '7 days ago', 'status' => 'scheduled'],
            ['name' => 'Analytics Report', 'schedule' => '0 9 * * MON', 'nextRun' => '3 days', 'lastRun' => '7 days ago', 'status' => 'scheduled'],
            ['name' => 'Cache Warmer', 'schedule' => '*/15 * * * *', 'nextRun' => '12 minutes', 'lastRun' => '2 minutes ago', 'status' => 'running']
        ];
    }

    public function getActiveSessions(): array
    {
        return [
            ['id' => 1, 'user' => 'admin@company.com', 'loginTime' => '2h ago', 'autoDeleteIn' => '46 minutes', 'ip' => '192.168.1.100'],
            ['id' => 2, 'user' => 'dev@company.com', 'loginTime' => '1h ago', 'autoDeleteIn' => '1h 46min', 'ip' => '192.168.1.101'],
            ['id' => 3, 'user' => 'temp-user-123', 'loginTime' => '30m ago', 'autoDeleteIn' => '29 minutes 30s', 'ip' => '192.168.1.102']
        ];
    }

    public function getDockerContainers(): array
    {
        return [
            ['id' => 'web-01', 'name' => 'web-app', 'status' => 'running', 'image' => 'laravel:8.0', 'memory' => '512 MB', 'cpu' => '34%', 'ports' => ['80:80', '443:443']],
            ['id' => 'db-01', 'name' => 'postgres', 'status' => 'running', 'image' => 'postgres:14', 'memory' => '2 GB', 'cpu' => '12%', 'ports' => ['5432:5432']],
            ['id' => 'cache-01', 'name' => 'redis', 'status' => 'running', 'image' => 'redis:7', 'memory' => '256 MB', 'cpu' => '8%', 'ports' => ['6379:6379']],
            ['id' => 'queue-01', 'name' => 'queue-worker', 'status' => 'running', 'image' => 'laravel-worker:latest', 'memory' => '256 MB', 'cpu' => '22%', 'ports' => []]
        ];
    }

    public function getAuditLogs(): array
    {
        return [
            ['id' => 1, 'type' => 'access_denied', 'user' => 'unknown', 'action' => 'SSH login attempt', 'timestamp' => '2 mins ago', 'ip' => '203.0.113.45', 'status' => 'blocked'],
            ['id' => 2, 'type' => 'command', 'user' => 'admin', 'action' => 'Deployed v1.2.3', 'timestamp' => '15 mins ago', 'ip' => '192.168.1.50', 'status' => 'success'],
            ['id' => 3, 'type' => 'access_denied', 'user' => 'attacker', 'action' => 'Brute force attempt', 'timestamp' => '1h ago', 'ip' => '198.51.100.23', 'status' => 'blocked'],
            ['id' => 4, 'type' => 'command', 'user' => 'dev', 'action' => 'Database migration run', 'timestamp' => '2h ago', 'ip' => '192.168.1.51', 'status' => 'success']
        ];
    }
}
