<?php

namespace App\Services\Infrastructure\Scheduler;

class SchedulerMonitorService
{
    public function getCronTasks(): array
    {
        return [
            ['name' => 'Cleanup Ephemeral Users', 'schedule' => '0 2 * * *', 'nextRun' => '2 hours', 'lastRun' => '24 hours ago', 'status' => 'scheduled'],
            ['name' => 'Database Backup', 'schedule' => '0 3 * * 0', 'nextRun' => '1 day', 'lastRun' => '7 days ago', 'status' => 'scheduled'],
            ['name' => 'Analytics Report', 'schedule' => '0 9 * * MON', 'nextRun' => '3 days', 'lastRun' => '7 days ago', 'status' => 'scheduled'],
            ['name' => 'Cache Warmer', 'schedule' => '*/15 * * * *', 'nextRun' => '12 minutes', 'lastRun' => '2 minutes ago', 'status' => 'running']
        ];
    }
}
