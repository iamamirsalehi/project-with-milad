<?php

namespace App\UI\Controller\API;

use App\Application\Command\AddSubscriptionCommand;
use App\Domain\Exceptions\BusinessException;
use App\Domain\Model\Subscription\DurationInMonth;
use App\Domain\Model\Subscription\Price;
use App\Infrastructure\CommandBus\CommandBus;
use App\UI\Request\API\SubscriptionRequest;
use App\UI\Response\JsonResponse;
use Illuminate\Http\Response;

final readonly class AdminSubscriptionController
{
    public function __construct(private CommandBus $commandBus,
    )
    {
    }

    public function add(SubscriptionRequest $request): Response
    {
        try {
            $name = $request->get('name');
            $price = new Price($request->get('price'));
            $durationInMonth = new DurationInMonth($request->get('duration_in_month'));

            $this->commandBus->handle(new AddSubscriptionCommand($name, $price, $durationInMonth));

        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('added');
    }
}
