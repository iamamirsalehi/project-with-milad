<?php

namespace App\Contracts\Redis;

interface IRedis
{
    public function publish(string $channel, string $message): void;
}
