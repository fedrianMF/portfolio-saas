<?php

namespace App\Services\Infrastructure\Queue;

class QueueMonitorService
{
    public function getQueueHealth(): array
    {
        return [
            'status' => 'warning', // Logic to determine status based on failed jobs
            'failedJobs' => rand(0, 5),
            'activeWorkers' => 8,
            'uptime' => '2d'
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
}
