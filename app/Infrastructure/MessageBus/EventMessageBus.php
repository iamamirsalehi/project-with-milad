<?php

namespace App\Infrastructure\MessageBus;

interface EventMessageBus
{
    public function getChannelName(): string;
}
