<?php

namespace App\Http\Controllers\API;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\SubscriptionRequest;
use App\Modules\Subscription\Models\DurationInMonth;
use App\Modules\Subscription\Models\Price;
use App\Modules\Subscription\Services\SubscriptionService\NewSubscription;
use App\Modules\Subscription\Services\SubscriptionService\SubscriptionService;
use Illuminate\Http\Response;

final readonly class AdminSubscriptionController
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
            $newSubscription = new NewSubscription(
                $name,
                new Price($price),
                new DurationInMonth($durationInMonth),
            );

            $this->subscriptionService->add($newSubscription);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('added');
    }
}
