<?php

namespace App\Domain\Repository;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserID;

interface UserRepository
{
    public function findByID(UserID $userID): ?User;
}
