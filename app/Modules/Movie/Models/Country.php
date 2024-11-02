<?php

namespace App\Modules\Movie\Models;

readonly class Country
{
    public function __construct(private string $country)
    {

    }

    public function get(): string
    {
        $this->validate();

        return $this->country;
    }

    private function validate(): void
    {

    }
}
