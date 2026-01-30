<?php

namespace App\Services\Infrastructure\Host\Strategies;

class LinuxSystemStatsStrategy implements SystemStatsStrategyInterface
{
    public function getCpuUsage(): int
    {
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return (int) ($load[0] * 10); // Approximation
        }
        return 0;
    }

    public function getMemoryUsage(): int
    {
        if (file_exists('/proc/meminfo')) {
            $data = explode("\n", file_get_contents('/proc/meminfo'));
            $memTotal = $memAvailable = 0;
            foreach ($data as $line) {
                if (preg_match('/^MemTotal:\s+(\d+)\s+kB$/i', $line, $matches)) $memTotal = (int)$matches[1];
                if (preg_match('/^MemAvailable:\s+(\d+)\s+kB$/i', $line, $matches)) $memAvailable = (int)$matches[1];
            }
            if ($memTotal > 0) {
                return (int) ((($memTotal - $memAvailable) / $memTotal) * 100);
            }
        }
        return 0;
    }

    public function getDiskUsage(): int
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');
        if ($total === false || $total === 0) return 0;
        return (int) ((($total - $free) / $total) * 100);
    }

    public function getUptime(): string
    {
        if (file_exists('/proc/uptime')) {
            $uptime = (int) explode(' ', file_get_contents('/proc/uptime'))[0];
            return $this->formatUptime($uptime);
        }
        return '0d 0h';
    }

    public function getOsInfo(): string
    {
        return php_uname('s') . ' ' . php_uname('r');
    }

    private function formatUptime(int $uptime): string
    {
        $days = floor($uptime / 86400);
        $hours = floor(($uptime % 86400) / 3600);
        return "{$days}d {$hours}h";
    }
}
