<?php

namespace App\Infrastructure\Service\Notification;

use App\Domain\Service\Notification\Message;
use App\Domain\Service\Notification\Notification;

final class KavenegarProvider implements Notification
{
    public function dispatch(Message $message): void
    {
        // TODO: Implement dispatch() method.
    }
}
