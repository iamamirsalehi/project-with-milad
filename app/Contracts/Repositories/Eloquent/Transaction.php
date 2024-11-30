<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\ITransaction;
use Illuminate\Support\Facades\DB;

class Transaction implements ITransaction
{
    public function begin(callable $callable): void
    {
        DB::transaction($callable);
    }
}
