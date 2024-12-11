<?php

namespace App\Domain\Resolver;

interface Resolver
{
    public function resolve(string $class);
}
