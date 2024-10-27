<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\V1\SubscribeRequest;
use App\Modules\Subscription\Services\UserSubscriptionService\UserSubscriptionService;
use Illuminate\Http\Response;

class UserSubscriptionController
{
    public function __construct(private UserSubscriptionService $userSubscriptionService)
    {
    }

    public function subscribe(SubscribeRequest $request): Response
    {
        try {
            $this->userSubscriptionService->subscribe(
                $request->get('user_id'),
                $request->get('subscription_id'),
            );
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('subscribed');
    }
}
