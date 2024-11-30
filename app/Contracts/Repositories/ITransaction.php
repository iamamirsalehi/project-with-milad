<?php

namespace App\Contracts\Repositories;

interface ITransaction
{
    public function begin(callable $callable);
}
