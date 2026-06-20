<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface TagRepositoryInterface
{
    public function all(): Collection;
}
