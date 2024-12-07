<?php

namespace App\Src\Instrastructure\Persistance\Repository\Eloquent;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentBaseRepository
{
    public function __construct(protected Model $model)
    {
    }
}
