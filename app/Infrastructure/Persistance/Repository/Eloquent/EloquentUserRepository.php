<?php

namespace App\Infrastructure\Persistance\Repository\Eloquent;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserID;
use App\Domain\Repository\UserRepository;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
    public function findByID(UserID $userID): ?User
    {
        return $this->model->newQuery()
            ->where('id', $userID)
            ->first();
    }
}
