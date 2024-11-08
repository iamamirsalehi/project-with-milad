<?php

namespace App\Contracts\Redis;

use Illuminate\Support\Facades\Redis;

class LaravelRedisClient implements IRedis
{
    public function publish(string $channel, string $message): void
    {
        Redis::publish($channel, $message);
    }
}
