<?php

namespace App\Services\Infrastructure\Host\Strategies;

interface SystemStatsStrategyInterface
{
    public function getCpuUsage(): int;
    public function getMemoryUsage(): int;
    public function getDiskUsage(): int;
    public function getUptime(): string;
    public function getOsInfo(): string;
}
