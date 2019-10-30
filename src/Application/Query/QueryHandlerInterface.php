<?php

namespace PhpCommons\CQRSBus\Application\Query;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface QueryHandlerInterface extends MessageHandlerInterface
{
    public function handle(QueryInterface $query);
}