<?php

namespace App\Application\Service\MovieAccessService;

use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\User\UserID;
use App\Domain\Repository\MovieRentRepository;
use App\Domain\Repository\UserSubscriptionRepository;

final readonly class MovieAccessService
{
    public function __construct(
        private UserSubscriptionRepository $userSubscriptionRepository,
        private MovieRentRepository        $movieRentRepository,
    )
    {
    }

    public function hasAccessToMovie(UserID $userID, IMDBID $iMDBID): bool
    {
        $userSubscription = $this->userSubscriptionRepository->findByUserID($userID);
        if (!is_null($userSubscription) && $userSubscription->isActive()) {
            return true;
        }

        $movieRent = $this->movieRentRepository->findLatestByUserIDAndMovieID($userID, $iMDBID);
        if (!is_null($movieRent) && $movieRent->isActive()) {
            return true;
        }

        return false;
    }
}
