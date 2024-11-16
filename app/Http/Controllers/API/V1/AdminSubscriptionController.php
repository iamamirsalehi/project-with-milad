<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\V1\SubscriptionRequest;
use App\Modules\Subscription\Models\DurationInMonth;
use App\Modules\Subscription\Models\Price;
use App\Modules\Subscription\Services\SubscriptionService\NewSubscription;
use App\Modules\Subscription\Services\SubscriptionService\SubscriptionService;
use Illuminate\Http\Response;

readonly class AdminSubscriptionController
{
    public function __construct(private SubscriptionService $subscriptionService)
    {
    }

    public function add(SubscriptionRequest $request): Response
    {
        $name = $request->get('name');
        $price = $request->get('price');
        $durationInMonth = $request->get('duration_in_month');
        try {
            $subscriptionData = new NewSubscription(
                $name,
                new Price($price),
                new DurationInMonth($durationInMonth),
            );

            $this->subscriptionService->add($subscriptionData);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('added');
    }
}
