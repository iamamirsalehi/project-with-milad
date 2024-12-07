<?php

use App\Src\Application\CommandHandler\Movie\AddMovieCommandHandler;
use Symfony\Component\Messenger\Handler\HandlersLocatorInterface;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\Handler\HandlerDescriptor;
use App\Src\Application\Command\Movie\AddMovieCommand;

return [
    'default_bus' => 'command.bus',
    'buses' => [
        'command.bus' => [
        ],
    ],
];
