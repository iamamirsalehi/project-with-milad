<?php

namespace App\Infrastructure\QueryBus;

use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyQueryBus implements QueryBus
{

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function handle(object $query)
    {
        return $this->messageBus->dispatch($query);
    }
}
