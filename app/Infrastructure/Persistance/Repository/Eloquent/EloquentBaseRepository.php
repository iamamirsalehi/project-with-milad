<?php

namespace App\Infrastructure\Persistance\Repository\Eloquent;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentBaseRepository
{
    public function __construct(protected Model $model)
    {
    }
}
