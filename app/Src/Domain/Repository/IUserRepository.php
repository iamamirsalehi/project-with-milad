<?php

namespace App\Src\Domain\Repository;

use App\Src\Domain\Model\User\User;
use App\Src\Domain\Model\User\UserID;

interface IUserRepository
{
    public function findByID(UserID $userID): ?User;
}
