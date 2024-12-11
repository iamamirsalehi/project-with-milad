<?php

namespace App\Infrastructure\MessageBus;

use Illuminate\Support\Facades\Redis;

class RedisMessageBus implements MessageBus
{
    public function dispatch(EventMessageBus $message): void
    {
        Redis::publish($message->getChannelName(), serialize($message));
    }
}
