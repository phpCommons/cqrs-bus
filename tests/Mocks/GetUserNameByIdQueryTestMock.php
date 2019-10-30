<?php

namespace Tests\Mocks;

use PhpCommons\CQRSBus\Application\Query\QueryInterface;

class GetUserNameByIdQueryTestMock implements QueryInterface
{
    /** @var int */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}