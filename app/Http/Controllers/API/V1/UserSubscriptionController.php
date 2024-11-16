<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\V1\SubscribeRequest;
use App\Modules\Subscription\Models\SubscriptionID;
use App\Modules\Subscription\Services\UserSubscriptionService\UserSubscriptionService;
use App\Modules\User\Models\UserID;
use Illuminate\Http\Response;

readonly class UserSubscriptionController
{
    public function __construct(private UserSubscriptionService $userSubscriptionService)
    {
    }

    public function subscribe(SubscribeRequest $request): Response
    {
        $userID = $request->get('user_id');
        $subscriptionID = $request->get('subscription_id');
        try {
            $this->userSubscriptionService->subscribe(
                new UserID($userID),
                new SubscriptionID($subscriptionID),
            );
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('subscribed');
    }
}
