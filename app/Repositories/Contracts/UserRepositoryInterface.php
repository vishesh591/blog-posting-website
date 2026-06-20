<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function popularAuthors(int $limit = 5): Collection;

    public function findAuthorById(int $id): User;
}
