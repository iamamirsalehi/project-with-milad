<?php

namespace App\Src\Instrastructure\Resolver;

use App\Src\Domain\Resolver\IResolver;
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
