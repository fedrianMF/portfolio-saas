<?php

namespace App\Services\Infrastructure\Security;

class SecurityMonitorService
{
    public function getSecurityMetrics(): array
    {
        return [
            'securityScore' => 87,
            'blockedRequests' => rand(300, 400),
            'failedLogins' => rand(5, 15),
            'activeSessions' => 5
        ];
    }

    public function getActiveSessions(): array
    {
        return [
            ['id' => 1, 'user' => 'admin@company.com', 'loginTime' => '2h ago', 'autoDeleteIn' => '46 minutes', 'ip' => '192.168.1.100'],
            ['id' => 2, 'user' => 'dev@company.com', 'loginTime' => '1h ago', 'autoDeleteIn' => '1h 46min', 'ip' => '192.168.1.101'],
            ['id' => 3, 'user' => 'temp-user-123', 'loginTime' => '30m ago', 'autoDeleteIn' => '29 minutes 30s', 'ip' => '192.168.1.102']
        ];
    }

    public function getAuditLogs(): array
    {
        return [
            ['id' => 1, 'type' => 'access_denied', 'user' => 'unknown', 'action' => 'SSH login attempt', 'timestamp' => '2 mins ago', 'ip' => '203.0.113.45', 'status' => 'blocked'],
            ['id' => 2, 'type' => 'command', 'user' => 'admin', 'action' => 'Deployed v1.2.3', 'timestamp' => '15 mins ago', 'ip' => '192.168.1.50', 'status' => 'success'],
            ['id' => 3, 'type' => 'access_denied', 'user' => 'attacker', 'action' => 'Brute force attempt', 'timestamp' => '1h ago', 'ip' => '198.51.100.23', 'status' => 'blocked'],
            ['id' => 4, 'type' => 'command', 'user' => 'dev', 'action' => 'Database migration run', 'timestamp' => '2h ago', 'ip' => '192.168.1.51', 'status' => 'success']
        ];
    }
}
