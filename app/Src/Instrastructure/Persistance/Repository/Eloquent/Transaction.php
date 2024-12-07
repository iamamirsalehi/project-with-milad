<?php

namespace App\Src\Instrastructure\Persistance\Repository\Eloquent;

use App\Src\Domain\Repository\ITransaction;
use Illuminate\Support\Facades\DB;

class Transaction implements ITransaction
{
    public function wrap(callable $callable): void
    {
        DB::transaction($callable);
    }
}
