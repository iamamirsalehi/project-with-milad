<?php

namespace App\Infrastructure\QueryBus;

interface QueryBus
{
    public function handle(object $query);
}
