<?php

namespace App\Src\Instrastructure\Service\Notification;

use App\Src\Domain\Service\Notification\IMessage;
use App\Src\Domain\Service\Notification\INotification;

final class KavenegarProvider implements INotification
{
    public function dispatch(IMessage $message): void
    {
        // TODO: Implement dispatch() method.
    }
}
