<?php
declare(strict_types=1);

namespace Tests\Mocks;

use PhpCommons\CQRSBus\Application\Command\CommandInterface;

class SaveNameCommandTestMock implements CommandInterface
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}