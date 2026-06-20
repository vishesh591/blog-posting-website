<?php

namespace App\Services;

use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function __construct(private readonly DashboardRepositoryInterface $dashboard)
    {
    }

    public function overview(int $userId, string $role): array
    {
        return Cache::remember("dashboard.{$role}.{$userId}", now()->addMinutes(5), fn () => $this->dashboard->statsForUser($userId, $role));
    }
}
