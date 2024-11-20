<?php

namespace App\Modules\Notification\Service;

use App\Modules\User\Models\User;

interface INotification
{
    public function dispatch(IMessage $message): void;
}
