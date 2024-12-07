<?php

namespace App\Src\Instrastructure\Resolver;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;

readonly class LaravelResolver implements IResolver
{
    public function __construct(private Container $container)
    {
    }

    /**
     * @throws BindingResolutionException
     */
    public function resolve(string $class)
    {
        return $this->container->make($class);
    }
}
