<?php

namespace App\Src\Domain\Model\Movie;

final readonly class Language
{
    public function __construct(private string $language)
    {
    }

    public function toPrimitiveType(): string
    {
        return $this->language;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
