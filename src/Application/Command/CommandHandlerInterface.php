<?php

namespace PhpCommons\CQRSBus\Application\Command;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface CommandHandlerInterface extends MessageHandlerInterface
{
    public function handle(CommandInterface $command): void;
}