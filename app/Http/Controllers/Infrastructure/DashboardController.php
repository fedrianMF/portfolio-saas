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
use Linfo\Linfo;


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
        $linfo  = new \Linfo\Linfo();
        $parser = $linfo->getParser();

        // Helper para llamar métodos solo si existen
        $safe = fn(string $method) => method_exists($parser, $method) ? $parser->$method() : null;

        $telemetry = $this->hostMonitor->getResourceTelemetry();
        $servicesStatus = $this->connectivityMonitor->getServicesStatus();

        $dash = [
            // ── PHP nativo ───────────────────────────────────
            "SERVER_SOFTWARE"    => $_SERVER['SERVER_SOFTWARE'] ?? null,
            "SERVER_ADDR"        => $_SERVER['SERVER_ADDR'] ?? gethostbyname(gethostname()),

            // ── Sistema base ─────────────────────────────────
            "os"           => $safe('getOS'),
            "kernel"       => $safe('getKernel'),
            "hostname"     => $safe('getHostname'),
            "architecture" => $safe('getCpuArchitecture'),
            "model"        => $safe('getModel'),
            "distro"       => $safe('getDistro'),        // null en macOS/Windows

            // ── CPU ──────────────────────────────────────────
            "cpu"          => $safe('getCpu'),
            "cpu_load"     => $safe('getLoad'),
            "cpu_usage"    => $safe('getCpuUsage'),      // null en macOS/Windows

            // ── Memoria ──────────────────────────────────────
            "ram"          => $safe('getRam'),

            // ── Tiempo activo ────────────────────────────────
            "uptime"       => $safe('getUptime'),

            // ── Almacenamiento ───────────────────────────────
            "mounts"       => $safe('getMounts'),
            "drives"       => $safe('getDrives'),
            "raid"         => $safe('getRaid'),          // null en macOS/Windows

            // ── Red ──────────────────────────────────────────
            "network"      => $safe('getNet'),

            // ── Hardware ─────────────────────────────────────
            "devices"      => $safe('getDevs'),          // null en macOS/Windows
            "temperatures" => $safe('getTemps'),
            "batteries"    => $safe('getBattery'),       // null en macOS/Windows

            // ── Procesos ─────────────────────────────────────
            "processes"    => $safe('getProcessStats'),

            // ── PHP ──────────────────────────────────────────
            "php_version"  => $safe('getPhpVersion'),    // null en macOS/Windows
            "extensions"   => $safe('getPhpExtensions'), // null en macOS/Windows

        ];

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
            'dash' => $dash
        ]);
    }
}
