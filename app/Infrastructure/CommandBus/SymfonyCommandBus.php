<?php

namespace App\Infrastructure\CommandBus;

use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBus;

class SymfonyCommandBus implements CommandBus
{

    public function __construct(private MessageBus $messageBus)
    {

    }

    /**
     * @throws ExceptionInterface
     */
    public function handle(object $command): void
    {
        $this->messageBus->dispatch($command);
    }
}
