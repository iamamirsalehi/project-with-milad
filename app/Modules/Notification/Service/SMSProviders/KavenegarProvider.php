<?php

namespace App\Modules\Notification\Service\SMSProviders;

use App\Modules\Notification\Service\IMessage;
use App\Modules\Notification\Service\INotification;

final class KavenegarProvider implements INotification
{
    public function dispatch(IMessage $message): void
    {
        // TODO: Implement dispatch() method.
    }
}
