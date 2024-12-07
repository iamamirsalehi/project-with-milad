<?php

namespace App\Src\UI\Controller\API;

use App\Src\Application\Command\Payment\PayRentCommand;
use App\Src\Application\Command\Payment\PaySubscriptionCommand;
use App\Src\Application\Command\Payment\VerifyPaymentCommand;
use App\Src\Domain\Exceptions\BusinessException;
use App\Src\Domain\Model\Movie\Duration;
use App\Src\Domain\Model\Movie\IMDBID;
use App\Src\Domain\Model\Payment\PaymentID;
use App\Src\Domain\Model\Subscription\SubscriptionID;
use App\Src\Domain\Model\User\UserID;
use App\Src\UI\Request\API\PayRentRequest;
use App\Src\UI\Request\API\PaySubscriptionRequest;
use App\Src\UI\Request\API\VerifyRequest;
use App\Src\UI\Response\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class UserPaymentController
{
    public function __construct(
        private MessageBusInterface $messageBus,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function payRent(PayRentRequest $request): Response
    {
        try {
            $imdbID = new IMDBID($request->get('imdb_id'));
            $userID = new UserID($request->get('user_id'));
            $hours = new Duration($request->get('hours'));
            $paymentMethod = $request->get('method');

            $this->messageBus->dispatch(new PayRentCommand($userID, $imdbID, $hours, $paymentMethod));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('payment process started');
    }

    /**
     * @throws ExceptionInterface
     */
    public function paySubscription(PaySubscriptionRequest $request): Response
    {
        try {
            $subscriptionID = new SubscriptionID($request->get('subscription_id'));
            $userID = new UserID($request->get('user_id'));
            $paymentMethod = $request->get('method');

            $this->messageBus->dispatch(new PaySubscriptionCommand($userID, $subscriptionID, $paymentMethod));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('payment process started');
    }

    /**
     * @throws ExceptionInterface
     */
    public function verify(VerifyRequest $request): Response
    {
        try {
            $paymentID = new PaymentID($request->get('payment_id'));

            $this->messageBus->dispatch(new VerifyPaymentCommand($paymentID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('verified');
    }
}
