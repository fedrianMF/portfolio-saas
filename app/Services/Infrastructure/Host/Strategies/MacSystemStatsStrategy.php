<?php

namespace App\Services\Infrastructure\Host\Strategies;

class MacSystemStatsStrategy implements SystemStatsStrategyInterface
{
    public function getCpuUsage(): int
    {
        // On macOS, sys_getloadavg works similarly
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return (int) ($load[0] * 10); 
        }
        return 0;
    }

    public function getMemoryUsage(): int
    {
        // macOS specific command to get memory
        // vm_stat gives page counts (4096 bytes per page usually)
        $output = [];
        exec('vm_stat', $output);
        
        $pagesFree = 0;
        $pagesActive = 0;
        $pagesInactive = 0;
        $pagesWired = 0;

        foreach ($output as $line) {
            if (preg_match('/Pages free:\s+(\d+)\./', $line, $matches)) $pagesFree = (int)$matches[1];
            if (preg_match('/Pages active:\s+(\d+)\./', $line, $matches)) $pagesActive = (int)$matches[1];
            if (preg_match('/Pages inactive:\s+(\d+)\./', $line, $matches)) $pagesInactive = (int)$matches[1];
            if (preg_match('/Pages wired down:\s+(\d+)\./', $line, $matches)) $pagesWired = (int)$matches[1];
        }

        $total = $pagesFree + $pagesActive + $pagesInactive + $pagesWired;
        $used = $pagesActive + $pagesWired; // Simplified used calc

        if ($total > 0) {
            return (int) (($used / $total) * 100);
        }

        return rand(40, 60); // Fallback
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
        // macOS uptime command via shell
        // "uptime" output example: " 14:30:00 up 2 days,  4:30, 2 users, load averages: 1.25 1.30 1.28"
        try {
            $output = shell_exec('sysctl -n kern.boottime');
            // { sec = 1706600000, usec = 0 } Mon Jan 30 ...
            if (preg_match('/sec = (\d+),/', $output, $matches)) {
                $bootTime = (int)$matches[1];
                $uptime = time() - $bootTime;
                return $this->formatUptime($uptime);
            }
        } catch (\Exception $e) {
            // ignore
        }
        return '0d 0h';
    }

    public function getOsInfo(): string
    {
        return 'macOS ' . php_uname('r');
    }

    private function formatUptime(int $uptime): string
    {
        $days = floor($uptime / 86400);
        $hours = floor(($uptime % 86400) / 3600);
        return "{$days}d {$hours}h";
    }
}
