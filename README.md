# cqrs-bus
CQRS Bus is Symfony 4.3+ Bundle with Command Bus &amp; QueryBus using Symfony Messanger

## Installation
```bash
composer require php-commons/cqrs-bus
```

## Configuration
`config/services.yaml`
### CommandBus
#### Handler's configuration
```yaml
services:
    App\CommandHandler\MyOwnCommandHandler:
        autoconfigure: false
        tags:
            - { name: messenger.message_handler, bus: command.bus }
    ...
    App\CommandHandler\MyCustomCommandHandler:
        autoconfigure: false
        tags:
            - { name: messenger.message_handler, bus: command.bus }
    ...
```
or
```yaml
command_handlers:
    namespace: App\CommandHandler\
    resource: '%kernel.project_dir%/src/CommandHandler/*CommandHandler.php'
    autoconfigure: false
    tags:
        - { name: messenger.message_handler, bus: command.bus }
```

It's **VERY** important to tag ALL of yours Commands Handlers with: `{ name: messenger.message_handler, bus: command.bus }`, otherwise other MessageHandler can handle query.
It's **VERY** important to extend ALL of yours Commands Handlers from: `PhpCommons\CQRSBus\Handlers\Command\AbstractCommandHandler`, otherwise CommandHandler will not find it.


### QueryBus
#### Handler's configuration
You need to configure your handler in /config/services.yml
```yaml
    App\Query\MyOwnQueryHandler:
        autoconfigure: false
        tags:
            - { name: messenger.message_handler, bus: query.bus }
```
or
```yaml
query_handlers:
    namespace: App\MessageHandler\
    resource: '%kernel.project_dir%/src/MessageHandler/*QueryHandler.php'
    autoconfigure: false
    tags:
        - { name: messenger.message_handler, bus: query.bus }
```

It's **VERY** important to tag ALL of yours Queries Handlers with: `{ name: messenger.message_handler, bus: query.bus }`, otherwise other MessageHandler can handle query.
It's **VERY** important to extend ALL of yours Queries Handlers from: `PhpCommons\CQRSBus\Handlers\Query\AbstractQueryHandler`, otherwise QueryHandler will not find it.

## Usage
### CommandBus
```php
<?php
declare(strict_types=1);

namespace App\Controller;

use PhpCommons\CQRSBus\Bus\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $this->commandBus->handle(new TestCommand('test_message'));
    }
}
```
### Command:
```php
<?php
declare(strict_types=1);

namespace App\Command;

use PhpCommons\CQRSBus\Application\Command\CommandInterface;

class TestCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
```
### CommandHandler:
```php
<?php 
declare(strict_types=1);
namespace App\Command;

use App\Repositories\UserRepository;
use PhpCommons\CQRSBus\Application\Command\CommandInterface;
use PhpCommons\CQRSBus\Handlers\Command\AbstractCommandHandler;

class TestCommandHandler extends AbstractCommandHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param CommandInterface|TestCommand $command
     */
    public function handle(CommandInterface $command): void
    {
        $this->userRepository->save($command->getMessage());
    }
}
```
### QueryBus
```php
<?php
declare(strict_types=1);

namespace App\Controller;

use App\Query\TestQuery;
use PhpCommons\CQRSBus\QueryBus\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tests")
 */
class UsersController extends AbstractController
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("/{id}", name="get_test")
     */
    public function getTest(int $id)
    {
        // GetUserByIdQuery(1)
        $testQueryResult = $this->queryBus->handle(new TestQuery(1));
    }
}
```
### Query:
```php
<?php
declare(strict_types=1);

namespace App\Query;

use PhpCommons\CQRSBus\QueryBus\AbstractQuery;

class TestQuery extends AbstractQuery
{
    /**
     * @var int
     */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
```
### QueryHandler:
```php
<?php
declare(strict_types=1);

namespace App\Query;

use PhpCommons\CQRSBus\Application\Query\QueryInterface;
use PhpCommons\CQRSBus\Handlers\Query\AbstractQueryHandler;

class TestQueryHandler extends AbstractQueryHandler
{
    /**
     * @var TestRepository
     */
    private $testRepository;

    public function __construct(TestRepository $testRepository)
    {
        $this->testRepository = $testRepository;
    }

    /**
     * @param QueryInterface|TestQuery $query
     */
    public function handle(QueryInterface $query): object
    {
        return $this->testRepository->findById($query->getId());
    }
}
```
