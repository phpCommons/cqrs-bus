<?php
declare(strict_types=1);

namespace Tests\Unit\Handlers\Command;

use PhpCommons\CQRSBus\Handlers\Query\AbstractQueryHandler;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\GetUserNameByIdQueryTestMock;

class QueryHandlerTest extends TestCase
{
    /** @test */
    public function whenHandlerCalledAsFunctionThenExpectsHandleMethodsHasBeenExecuted(): void
    {
        $testCommandHandler = $this->createPartialMock(AbstractQueryHandler::class, ['handle']);
        $testCommandHandler
            ->expects($this->once())
            ->method('handle')
            ->willReturn(0);

        $query = new GetUserNameByIdQueryTestMock(999999);
        $testCommandHandler($query);
    }
}
