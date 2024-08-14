<?php

declare(strict_types=1);

namespace App\Services;

interface RedisServiceInterface
{
    public function get(mixed $key): mixed;

    public function save(mixed $key, mixed $data): bool;
}
