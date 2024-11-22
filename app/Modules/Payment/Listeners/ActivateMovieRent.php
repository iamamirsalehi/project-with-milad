<?php

namespace App\Modules\Payment\Listeners;

use App\Contracts\Repositories\Eloquent\MovieRentRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\MovieID;
use App\Modules\Movie\Models\MovieRent;
use App\Modules\Movie\Services\MovieRentService\MovieRentService;
use App\Modules\Movie\Services\MovieService\NewMovieRent;
use App\Modules\Payment\Events\PaidEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

readonly class ActivateMovieRent implements ShouldQueue
{
    public function __construct(
        private MovieRentService $movieRentService,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function handle(PaidEvent $paidEvent): void
    {
        $payment = $paidEvent->payment;

        if ($payment->paymentable_type->toPrimitiveType() != (new MovieRent())->getMorphClass()) {
            return;
        }

        $newMovieRent = new NewMovieRent(
            new MovieID($payment->paymentable_id->toPrimitiveType()),
            $payment->user_id,
        );

        $this->movieRentService->rent($newMovieRent);
    }
}
