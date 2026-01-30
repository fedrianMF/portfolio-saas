<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Infrastructure\Host\HostMonitorService;
use App\Services\Infrastructure\Connectivity\ConnectivityMonitorService;
use App\Services\Infrastructure\Queue\QueueMonitorService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        protected HostMonitorService $hostMonitor,
        protected ConnectivityMonitorService $connectivityMonitor,
        protected QueueMonitorService $queueMonitor
    ) {}

    public function index(): Response
    {
        $telemetry = $this->hostMonitor->getResourceTelemetry();
        $servicesStatus = $this->connectivityMonitor->getServicesStatus();

        return Inertia::render('Home/Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            // Pass system data for the live preview
            'healthData' => [
                'vps' => array_merge(['status' => 'healthy'], $this->hostMonitor->getSystemHealth()),
                'postgresql' => $servicesStatus['database'],
                'redis' => $servicesStatus['redis'],
                'queue' => $this->queueMonitor->getQueueHealth(),
            ],
            'cpuData' => $telemetry['cpu'],
            'memoryData' => $telemetry['memory'],
        ]);
    }
}
