<?php

namespace App\UI\Controller\API;

use App\Application\Command\PayRentCommand;
use App\Application\Command\PaySubscriptionCommand;
use App\Application\Command\VerifyPaymentCommand;
use App\Domain\Exceptions\BusinessException;
use App\Domain\Model\Movie\Duration;
use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\Payment\PaymentID;
use App\Domain\Model\Subscription\SubscriptionID;
use App\Domain\Model\User\UserID;
use App\Infrastructure\CommandBus\CommandBus;
use App\UI\Request\API\PayRentRequest;
use App\UI\Request\API\PaySubscriptionRequest;
use App\UI\Request\API\VerifyRequest;
use App\UI\Response\JsonResponse;
use Illuminate\Http\Response;

final readonly class UserPaymentController
{
    public function __construct(
        private CommandBus $commandBus,
    )
    {
    }

    public function payRent(PayRentRequest $request): Response
    {
        try {
            $imdbID = new IMDBID($request->get('imdb_id'));
            $userID = new UserID($request->get('user_id'));
            $hours = new Duration($request->get('hours'));
            $paymentMethod = $request->get('method');

            $this->commandBus->handle(new PayRentCommand($userID, $imdbID, $hours, $paymentMethod));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('payment process started');
    }

    public function paySubscription(PaySubscriptionRequest $request): Response
    {
        try {
            $subscriptionID = new SubscriptionID($request->get('subscription_id'));
            $userID = new UserID($request->get('user_id'));
            $paymentMethod = $request->get('method');

            $this->commandBus->handle(new PaySubscriptionCommand($userID, $subscriptionID, $paymentMethod));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('payment process started');
    }

    public function verify(VerifyRequest $request): Response
    {
        try {
            $paymentID = new PaymentID($request->get('payment_id'));

            $this->commandBus->handle(new VerifyPaymentCommand($paymentID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('verified');
    }
}
