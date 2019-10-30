<?php
declare(strict_types=1);

namespace PhpCommons\CQRSBus\Handlers\Command;

use PhpCommons\CQRSBus\Application\Command\CommandHandlerInterface;
use PhpCommons\CQRSBus\Application\Command\CommandInterface;

abstract class AbstractCommandHandler implements CommandHandlerInterface
{
    public function __invoke(CommandInterface $command): void
    {
        $this->handle($command);
    }
}