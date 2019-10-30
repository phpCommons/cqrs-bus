<?php
declare(strict_types=1);

namespace PhpCommons\CQRSBus\Bus\Query;

use PhpCommons\CQRSBus\Application\Query\QueryBusInterface;
use PhpCommons\CQRSBus\Application\Query\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class QueryBus implements QueryBusInterface
{
    /** @var MessageBusInterface */
    private $queryBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function handle(QueryInterface $query): array
    {
        $envelop = $this->queryBus->dispatch($query);
        /** @var HandledStamp $result */
        $result = $envelop->all(HandledStamp::class)[0];

        return $result->getResult();
    }
}