<?php

namespace App\Src\Domain\Service\Notification;

interface INotification
{
    public function dispatch(IMessage $message): void;
}
