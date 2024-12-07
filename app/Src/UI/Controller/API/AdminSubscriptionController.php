<?php

namespace App\Src\UI\Controller\API;

use App\Src\Application\Command\Subscription\AddSubscriptionCommand;
use App\Src\Domain\Exceptions\BusinessException;
use App\Src\Domain\Model\Subscription\DurationInMonth;
use App\Src\Domain\Model\Subscription\Price;
use App\Src\UI\Request\API\SubscriptionRequest;
use App\Src\UI\Response\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class AdminSubscriptionController
{
    public function __construct(private MessageBusInterface $messageBus,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function add(SubscriptionRequest $request): Response
    {
        try {
            $name = $request->get('name');
            $price = new Price($request->get('price'));
            $durationInMonth = new DurationInMonth($request->get('duration_in_month'));

            $this->messageBus->dispatch(new AddSubscriptionCommand($name, $price, $durationInMonth));

        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('added');
    }
}
