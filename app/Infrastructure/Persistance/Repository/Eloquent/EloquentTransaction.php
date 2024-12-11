<?php

namespace App\Infrastructure\Persistance\Repository\Eloquent;

use App\Domain\Repository\Transaction;
use Illuminate\Support\Facades\DB;

class EloquentTransaction implements Transaction
{
    public function wrap(callable $callable): void
    {
        DB::transaction($callable);
    }
}
