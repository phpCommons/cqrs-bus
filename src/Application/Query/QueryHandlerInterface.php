<?php

namespace PhpCommons\CQRSBus\Application\Query;

interface QueryHandlerInterface
{
    public function handle(QueryInterface $query);
}