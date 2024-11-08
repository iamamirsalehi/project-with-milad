<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\V1\SubscriptionRequest;
use App\Modules\Movie\Models\DurationInMonth;
use App\Modules\Movie\Models\Price;
use App\Modules\Subscription\Services\SubscriptionService\SubscriptionData;
use App\Modules\Subscription\Services\SubscriptionService\SubscriptionService;
use Illuminate\Http\Response;

readonly class AdminSubscriptionController
{
    public function __construct(private SubscriptionService $subscriptionService)
    {
    }

    public function add(SubscriptionRequest $request): Response
    {
        try {
            $subscriptionData = new SubscriptionData(
                $request->get('name'),
                new Price($request->get('price')),
                new DurationInMonth($request->get('duration_in_month')),
            );

            $this->subscriptionService->add($subscriptionData);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('added');
    }
}
