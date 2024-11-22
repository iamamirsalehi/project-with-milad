<?php

namespace App\Contracts\Resolver;

interface IResolver
{
    public function resolve(string $class);
}
