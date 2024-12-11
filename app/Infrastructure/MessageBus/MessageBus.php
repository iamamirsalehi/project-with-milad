<?php

namespace App\Infrastructure\MessageBus;

interface MessageBus
{
    public function dispatch(EventMessageBus $message): void;
}
