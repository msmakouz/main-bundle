<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle\Composer;

use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\KernelInterface;
use Zentlix\MainBundle\Domain\Bundle\Specification\ExistByPackageBundleSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class RemoveHandler implements CommandHandlerInterface
{
    public function __construct(
        private KernelInterface $kernel,
        private ExistByPackageBundleSpecification $existByPackageBundleSpecification
    ) {
    }

    public function __invoke(RemoveCommand $command): void
    {
        $this->existByPackageBundleSpecification->isExist($command->getPackage());

        set_time_limit(0);

        $application = new Application();
        $application->setAutoExit(false);
        $result = $application->run(new ArrayInput([
            'command' => 'remove',
            'packages' => [$command->getPackage()],
            '--working-dir' => $this->kernel->getProjectDir(),
        ]));

        if ($result > 0) {
            throw new \DomainException();
        }
    }
}
