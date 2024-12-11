<?php

namespace App\Domain\Service\Notification;

interface Message
{
    public function generate(): string;
}
