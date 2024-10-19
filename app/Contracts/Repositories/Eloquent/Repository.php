<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\Dto\BaseCreateData;
use App\Contracts\Repositories\Dto\BaseResult;
use App\Contracts\Repositories\Dto\BaseGetResult;
use App\Contracts\Repositories\IRepository;

class Repository implements IRepository
{
    public function create(BaseCreateData $data): BaseResult
    {
        // TODO: Implement create() method.
    }

    public function exists(string $imdbID): bool
    {
        // TODO: Implement exists() method.
    }

    public function get(string $imdbID): BaseGetResult
    {
        // TODO: Implement get() method.
    }
}
