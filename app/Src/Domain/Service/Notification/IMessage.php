<?php

namespace App\Src\Domain\Service\Notification;

interface IMessage
{
    public function generate(): string;
}
