<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle\Composer;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\KernelInterface;
use Composer\Console\Application;
use Zentlix\MainBundle\Domain\Bundle\Specification\ExistByPackageBundleSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class RemoveHandler implements CommandHandlerInterface
{
    private KernelInterface $kernel;
    private ExistByPackageBundleSpecification $existByPackageBundleSpecification;

    public function __construct(KernelInterface $kernel,
                                ExistByPackageBundleSpecification $existByPackageBundleSpecification)
    {
        $this->kernel = $kernel;
        $this->existByPackageBundleSpecification = $existByPackageBundleSpecification;
    }

    public function __invoke(RemoveCommand $command): void
    {
        $this->existByPackageBundleSpecification->isExist($command->getPackage());

        set_time_limit(0);

        $application = new Application();
        $application->setAutoExit(false);
        $result = $application->run(new ArrayInput([
            'command'       => 'remove',
            'packages'      => [$command->getPackage()],
            '--working-dir' => $this->kernel->getProjectDir()
        ]));

        if($result > 0) {
            throw new \DomainException();
        }
    }
}