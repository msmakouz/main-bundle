<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Composer;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Composer\Console\Application as ComposerApplication;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class RemoveHandler implements CommandHandlerInterface
{
    private Bundles $bundles;
    private KernelInterface $kernel;

    public function __construct(Bundles $bundles, KernelInterface $kernel)
    {
        $this->bundles = $bundles;
        $this->kernel = $kernel;
    }

    public function __invoke(RemoveCommand $command): void
    {
        set_time_limit(0);

        $package = $this->bundles->getByClass($command->getBundle()->getClass())->getBundleName();

        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $application->run(new ArrayInput([
            'command' => 'zentlix_main:remove',
            'bundle'  => $package
        ]), new NullOutput());

        $composerApplication = new ComposerApplication();
        $composerApplication->setAutoExit(false);
        $result = $composerApplication->run(new ArrayInput([
            'command'       => 'remove',
            'packages'      => [$package],
            '--working-dir' => $this->kernel->getProjectDir()
        ]));

        // rebooting the application after removing the package
        $this->kernel->shutdown();
        $this->kernel->boot();

        $application->run(new ArrayInput(['command' => 'doctrine:migrations:diff']), new NullOutput());
        $application->run(new ArrayInput([
            'command'          => 'doctrine:migrations:migrate',
            '--no-interaction' => true
        ]), new NullOutput());

        if($result > 0) {
            throw new \DomainException();
        }
    }
}