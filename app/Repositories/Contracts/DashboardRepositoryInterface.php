<?php

namespace App\Repositories\Contracts;

interface DashboardRepositoryInterface
{
    public function statsForUser(int $userId, string $role): array;
}
