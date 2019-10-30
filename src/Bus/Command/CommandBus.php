<?php
declare(strict_types=1);

namespace PhpCommons\CQRSBus\Bus\Command;

use PhpCommons\CQRSBus\Application\Command\CommandBusInterface;
use PhpCommons\CQRSBus\Application\Command\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements CommandBusInterface
{
    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(CommandInterface $command)
    {
        return $this->commandBus->dispatch($command);
    }
}