<?php

namespace App\Modules\Notification\Service;

interface IMessage
{
    public function generate(): string;
}
