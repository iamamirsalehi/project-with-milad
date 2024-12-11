<?php

namespace App\Infrastructure\CommandBus;

interface CommandBus
{
    public function handle(object $command): void;
}
