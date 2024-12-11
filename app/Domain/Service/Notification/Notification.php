<?php

namespace App\Domain\Service\Notification;

interface Notification
{
    public function dispatch(Message $message): void;
}
