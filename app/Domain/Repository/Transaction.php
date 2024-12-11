<?php

namespace App\Domain\Repository;

interface Transaction
{
    public function wrap(callable $callable);
}
