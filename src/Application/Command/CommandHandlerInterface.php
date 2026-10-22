<?php

namespace PhpCommons\CQRSBus\Application\Command;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command): void;
}