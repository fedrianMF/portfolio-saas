<?php

namespace App\Services\Infrastructure\Container;

class ContainerMonitorService
{
    public function getDockerContainers(): array
    {
        return [
            ['id' => 'web-01', 'name' => 'web-app', 'status' => 'running', 'image' => 'laravel:8.0', 'memory' => '512 MB', 'cpu' => '34%', 'ports' => ['80:80', '443:443']],
            ['id' => 'db-01', 'name' => 'postgres', 'status' => 'running', 'image' => 'postgres:14', 'memory' => '2 GB', 'cpu' => '12%', 'ports' => ['5432:5432']],
            ['id' => 'cache-01', 'name' => 'redis', 'status' => 'running', 'image' => 'redis:7', 'memory' => '256 MB', 'cpu' => '8%', 'ports' => ['6379:6379']],
            ['id' => 'queue-01', 'name' => 'queue-worker', 'status' => 'running', 'image' => 'laravel-worker:latest', 'memory' => '256 MB', 'cpu' => '22%', 'ports' => []]
        ];
    }
}
