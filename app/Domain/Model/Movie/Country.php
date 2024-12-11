<?php

namespace App\Domain\Model\Movie;

final readonly class Country
{
    public function __construct(private string $country)
    {
    }

    public function toPrimitiveType(): string
    {
        return $this->country;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
