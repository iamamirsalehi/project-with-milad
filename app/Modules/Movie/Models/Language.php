<?php

namespace App\Modules\Movie\Models;

readonly class Language
{
    public function __construct(private string $language)
    {
    }

    public function get(): string
    {
        $this->validate();

        return $this->language;
    }

    private function validate(): void
    {

    }
}
