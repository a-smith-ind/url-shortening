<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class RedisService implements RedisServiceInterface
{
    public function get(mixed $key): mixed
    {
        return Redis::get($key);
    }

    public function save(mixed $key, mixed $data): bool
    {
        return Redis::set($key, $data);
    }
}
