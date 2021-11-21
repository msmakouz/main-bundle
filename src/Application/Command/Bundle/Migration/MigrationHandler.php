<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle\Migration;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class MigrationHandler implements CommandHandlerInterface
{
    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function __invoke(MigrationCommand $command): void
    {
        set_time_limit(0);

        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $application->run(new ArrayInput(['command' => 'doctrine:migrations:diff']), new NullOutput());
        $application->run(new ArrayInput([
            'command' => 'doctrine:migrations:migrate',
            '--no-interaction' => true,
        ]), new NullOutput());
    }
}
