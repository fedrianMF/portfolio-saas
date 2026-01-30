<?php

namespace App\Services\Infrastructure\Host;

use App\Services\Infrastructure\Host\Strategies\SystemStatsStrategyInterface;
use App\Services\Infrastructure\Host\Strategies\LinuxSystemStatsStrategy;
use App\Services\Infrastructure\Host\Strategies\MacSystemStatsStrategy;
use App\Services\Infrastructure\Host\Strategies\WindowsSystemStatsStrategy;

class HostMonitorService
{
    private SystemStatsStrategyInterface $statsStrategy;

    public function __construct()
    {
        $this->statsStrategy = $this->getStrategyForSystem();
    }

    public function getSystemHealth(): array
    {
        return [
            'cpu' => $this->statsStrategy->getCpuUsage(),
            'memory' => $this->statsStrategy->getMemoryUsage(),
            'disk' => $this->statsStrategy->getDiskUsage(),
            'uptime' => $this->statsStrategy->getUptime(),
            'os' => $this->statsStrategy->getOsInfo(),
        ];
    }

    public function getResourceTelemetry(): array
    {
        $times = ['00:00', '04:00', '08:00', '12:00', '16:00', date('H:i')];

        $currentCpu = $this->statsStrategy->getCpuUsage();
        $currentMemory = $this->statsStrategy->getMemoryUsage();
        $currentDisk = $this->statsStrategy->getDiskUsage();

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

    private function getStrategyForSystem(): SystemStatsStrategyInterface
    {
        $os = PHP_OS_FAMILY;

        return match ($os) {
            'Windows' => new WindowsSystemStatsStrategy(),
            'Darwin' => new MacSystemStatsStrategy(), // macOS
            default => new LinuxSystemStatsStrategy(), // Helper for Linux/Unix
        };
    }
}
