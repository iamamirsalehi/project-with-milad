<?php

namespace App\Modules\Movie\Models;

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
