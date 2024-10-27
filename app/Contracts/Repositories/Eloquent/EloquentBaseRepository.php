<?php

namespace App\Contracts\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentBaseRepository
{
    public function __construct(protected Model $model)
    {
    }
}
