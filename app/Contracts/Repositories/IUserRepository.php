<?php

namespace App\Contracts\Repositories;

use App\Modules\User\Models\User;
use App\Modules\User\Models\UserID;

interface IUserRepository
{
    public function findByID(UserID $userID): ?User;
}
