<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\AdminUserService;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Psr\Container\ContainerInterface;

/**
 * @Command
 */
class TestCommand extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('test:command');
    }

    public function configure()
    {
        $this->setDescription('Hyperf Demo Command');
    }

    public function handle()
    {
        $userAdminService = new AdminUserService();
        $userAdminService->login('maple', '123456');
        $this->line('Hello Hyperf!', 'info');
    }
}
