<?php

namespace App\Http\Controllers\Infrastructure;

use App\Http\Controllers\Controller;
use App\Services\Infrastructure\Host\HostMonitorService;
use App\Services\Infrastructure\Connectivity\ConnectivityMonitorService;
use App\Services\Infrastructure\Queue\QueueMonitorService;
use App\Services\Infrastructure\Security\SecurityMonitorService;
use App\Services\Infrastructure\Scheduler\SchedulerMonitorService;
use App\Services\Infrastructure\Container\ContainerMonitorService;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        protected HostMonitorService $hostMonitor,
        protected ConnectivityMonitorService $connectivityMonitor,
        protected QueueMonitorService $queueMonitor,
        protected SecurityMonitorService $securityMonitor,
        protected SchedulerMonitorService $schedulerMonitor,
        protected ContainerMonitorService $containerMonitor
    ) {}

    public function index(): Response
    {
        $telemetry = $this->hostMonitor->getResourceTelemetry();
        $servicesStatus = $this->connectivityMonitor->getServicesStatus();

        return Inertia::render('Infrastructure/Dashboard', [
            'healthData' => [
                'vps' => array_merge(['status' => 'healthy'], $this->hostMonitor->getSystemHealth()),
                'postgresql' => $servicesStatus['database'],
                'redis' => $servicesStatus['redis'],
                'queue' => $this->queueMonitor->getQueueHealth(),
            ],
            'securityData' => $this->securityMonitor->getSecurityMetrics(),
            'cpuData' => $telemetry['cpu'],
            'memoryData' => $telemetry['memory'],
            'diskData' => $telemetry['disk'],
            'databasePerformance' => $this->connectivityMonitor->getDatabasePerformance(),
            'supervisorWorkers' => $this->queueMonitor->getWorkers(),
            'recentJobs' => $this->queueMonitor->getRecentJobs(),
            'cronTasks' => $this->schedulerMonitor->getCronTasks(),
            'activeSessions' => $this->securityMonitor->getActiveSessions(),
            'dockerContainers' => $this->containerMonitor->getDockerContainers(),
            'auditLogs' => $this->securityMonitor->getAuditLogs(),
        ]);
    }
}
