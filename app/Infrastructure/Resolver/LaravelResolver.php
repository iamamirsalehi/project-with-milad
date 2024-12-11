<?php

namespace App\Infrastructure\Resolver;

use App\Domain\Resolver\Resolver;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;

readonly class LaravelResolver implements Resolver
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
