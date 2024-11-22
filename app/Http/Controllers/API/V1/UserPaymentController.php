<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\V1\PayRentRequest;
use App\Http\Controllers\Requests\API\V1\PaySubscriptionRequest;
use App\Http\Controllers\Requests\API\V1\VerifyRequest;
use App\Modules\Movie\Models\Duration;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Models\PaymentID;
use App\Modules\Payment\Services\PaymentService\MovieRentPaymentService;
use App\Modules\Payment\Services\PaymentService\NewMovieRentPayment;
use App\Modules\Payment\Services\PaymentService\NewSubscriptionPayment;
use App\Modules\Payment\Services\PaymentService\PaymentService;
use App\Modules\Payment\Services\PaymentService\SubscriptionPayService;
use App\Modules\Subscription\Models\SubscriptionID;
use App\Modules\User\Models\UserID;
use Illuminate\Http\Response;

readonly class UserPaymentController
{
    public function __construct(
        private SubscriptionPayService  $subscriptionPayService,
        private MovieRentPaymentService $movieRentPaymentService,
        private PaymentService          $paymentService,
    )
    {
    }

    public function payRent(PayRentRequest $request): Response
    {
        $imdbID = $request->get('imdb_id');
        $userID = $request->get('user_id');
        $hours = $request->get('hours');
        $paymentMethod = $request->get('method');

        try {
            $newMovieRentPayment = new NewMovieRentPayment(
                new UserID($userID),
                new IMDBID($imdbID),
                new Duration($hours),
                PaymentMethod::from($paymentMethod),
            );

            $this->movieRentPaymentService->pay($newMovieRentPayment);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('payment process started');
    }

    public function paySubscription(PaySubscriptionRequest $request): Response
    {
        $subscriptionID = $request->get('subscription_id');
        $userID = $request->get('user_id');
        $paymentMethod = $request->get('method');

        try {
            $newSubscriptionPay = new NewSubscriptionPayment(
                new UserID($userID),
                new SubscriptionID($subscriptionID),
                PaymentMethod::from($paymentMethod),
            );

            $this->subscriptionPayService->pay($newSubscriptionPay);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('payment process started');
    }

    public function verify(VerifyRequest $request): Response
    {
        $paymentID = $request->get('payment_id');
        try {
            $this->paymentService->verify(new PaymentID($paymentID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('verified');
    }
}
