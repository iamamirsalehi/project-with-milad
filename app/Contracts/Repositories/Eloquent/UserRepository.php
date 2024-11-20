<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IUserRepository;
use App\Modules\User\Models\User;
use App\Modules\User\Models\UserID;

class UserRepository extends EloquentBaseRepository implements IUserRepository
{
    public function findByID(UserID $userID): ?User
    {
        return $this->model->newQuery()
            ->where('id', $userID)
            ->first();
    }
}
