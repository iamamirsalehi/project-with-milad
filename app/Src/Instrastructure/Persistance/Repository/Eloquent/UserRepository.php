<?php

namespace App\Src\Instrastructure\Persistance\Repository\Eloquent;

use App\Src\Domain\Model\User\User;
use App\Src\Domain\Model\User\UserID;
use App\Src\Domain\Repository\IUserRepository;

class UserRepository extends EloquentBaseRepository implements IUserRepository
{
    public function findByID(UserID $userID): ?User
    {
        return $this->model->newQuery()
            ->where('id', $userID)
            ->first();
    }
}
