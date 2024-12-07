<?php

namespace App\Src\Domain\Resolver;

interface IResolver
{
    public function resolve(string $class);
}
