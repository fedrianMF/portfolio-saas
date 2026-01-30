<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\Infrastructure\SystemMonitorService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        protected SystemMonitorService $monitorService
    ) {}

    public function index(): Response
    {
        $telemetry = $this->monitorService->getResourceTelemetry();

        return Inertia::render('Home/Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            // Pass system data for the live preview
            'healthData' => $this->monitorService->getSystemHealth(),
            'cpuData' => $telemetry['cpu'],
            'memoryData' => $telemetry['memory'],
        ]);
    }
}
