<?php

namespace App\Src\Domain\Repository;

interface ITransaction
{
    public function wrap(callable $callable);
}
