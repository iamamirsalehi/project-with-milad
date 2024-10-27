<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\V1\SubscriptionRequest;
use App\Modules\Subscription\Services\SubscriptionService\SubscriptionData;
use App\Modules\Subscription\Services\SubscriptionService\SubscriptionService;

class AdminSubscriptionController
{
    public function __construct(private SubscriptionService $subscriptionService)
    {

    }

    public function add(SubscriptionRequest $request)
    {
        try {
            $subscriptionData = new SubscriptionData(
                $request->get('name'),
                $request->get('price'),
                $request->get('duration_in_month')
            );

            $this->subscriptionService->add($subscriptionData);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('added');
    }
}
