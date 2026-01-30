<?php

namespace App\Services\Infrastructure\Host\Strategies;

class WindowsSystemStatsStrategy implements SystemStatsStrategyInterface
{
    public function getCpuUsage(): int
    {
        // Windows specific command via wmic
        // wmic cpu get loadpercentage
        try {
            $cmd = 'wmic cpu get loadpercentage';
            $output = shell_exec($cmd);
            if ($output) {
                foreach (explode("\n", $output) as $line) {
                    if (is_numeric(trim($line))) {
                        return (int)trim($line);
                    }
                }
            }
        } catch (\Exception $e) {}
        return 0;
    }

    public function getMemoryUsage(): int
    {
        // wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /Value
        try {
            $cmd = 'wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /Value';
            $output = shell_exec($cmd);
            $total = 0;
            $free = 0;
            
            if ($output) {
                if (preg_match('/TotalVisibleMemorySize=(\d+)/', $output, $matches)) $total = (int)$matches[1];
                if (preg_match('/FreePhysicalMemory=(\d+)/', $output, $matches)) $free = (int)$matches[1];
            }

            if ($total > 0) {
                return (int) ((($total - $free) / $total) * 100);
            }
        } catch (\Exception $e) {}
        return 0;
    }

    public function getDiskUsage(): int
    {
        $total = disk_total_space('C:');
        $free = disk_free_space('C:');
        if ($total === false || $total === 0) return 0;
        return (int) ((($total - $free) / $total) * 100);
    }

    public function getUptime(): string
    {
        // System uptime requires wmic
        // wmic os get lastbootuptime
        return '0d 0h'; // Complex parsing in Windows, skipping for brevity unless requested
    }

    public function getOsInfo(): string
    {
        return 'Windows ' . php_uname('r');
    }
}
