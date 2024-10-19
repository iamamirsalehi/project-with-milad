<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IRepository;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IRepository
{
    public function __construct(protected Model $model)
    {
    }


}
