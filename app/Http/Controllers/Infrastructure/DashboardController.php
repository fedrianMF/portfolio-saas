<?php

namespace App\Http\Controllers\Infrastructure;

use App\Http\Controllers\Controller;
use App\Services\Infrastructure\SystemMonitorService;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        protected SystemMonitorService $monitorService
    ) {}

    public function index(): Response
    {
        $telemetry = $this->monitorService->getResourceTelemetry();

        return Inertia::render('Infrastructure/Dashboard', [
            'healthData' => $this->monitorService->getSystemHealth(),
            'securityData' => $this->monitorService->getSecurityMetrics(),
            'cpuData' => $telemetry['cpu'],
            'memoryData' => $telemetry['memory'],
            'diskData' => $telemetry['disk'],
            'databasePerformance' => $this->monitorService->getDatabasePerformance(),
            'supervisorWorkers' => $this->monitorService->getWorkers(),
            'recentJobs' => $this->monitorService->getRecentJobs(),
            'cronTasks' => $this->monitorService->getCronTasks(),
            'activeSessions' => $this->monitorService->getActiveSessions(),
            'dockerContainers' => $this->monitorService->getDockerContainers(),
            'auditLogs' => $this->monitorService->getAuditLogs(),
        ]);
    }
}
