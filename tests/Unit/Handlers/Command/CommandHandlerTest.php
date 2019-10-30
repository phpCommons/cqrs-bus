<?php
declare(strict_types=1);

namespace Tests\Unit\Handlers\Command;

use PhpCommons\CQRSBus\Handlers\Command\AbstractCommandHandler;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\SaveNameCommandTestMock;

class CommandHandlerTest extends TestCase
{
    /** @test */
    public function whenHandlerCalledAsFunctionThenExpectsHandleMethodsHasBeenExecuted(): void
    {
        $testCommandHandler = $this->createPartialMock(AbstractCommandHandler::class, ['handle']);
        $testCommandHandler
            ->expects($this->once())
            ->method('handle');

        $command = new SaveNameCommandTestMock('exits');
        $testCommandHandler($command);
    }
}
