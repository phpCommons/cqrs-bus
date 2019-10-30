<?php

namespace PhpCommons\CQRSBus\Handlers\Query;

use PhpCommons\CQRSBus\Application\Query\QueryHandlerInterface;
use PhpCommons\CQRSBus\Application\Query\QueryInterface;

abstract class AbstractQueryHandler implements QueryHandlerInterface
{
    public function __invoke(QueryInterface $command)
    {
        return $this->handle($command);
    }
}