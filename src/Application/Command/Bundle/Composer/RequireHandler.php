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

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Bundle\FrameworkBundle\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Composer\Console\Application;
use Composer\Json\JsonFile;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class RequireHandler implements CommandHandlerInterface
{
    private KernelInterface $kernel;
    private LoggerInterface $logger;

    public function __construct(KernelInterface $kernel, LoggerInterface $logger)
    {
        $this->kernel = $kernel;
        $this->logger = $logger;
    }

    public function __invoke(RequireCommand $command): void
    {
        set_time_limit(0);

        $application = new Application();
        $application->setAutoExit(false);
        $output = new BufferedOutput();

        $application->run(new ArrayInput([
            'command'       => 'require',
            'packages'      => [$command->package],
            '--working-dir' => $this->kernel->getProjectDir()
        ]), $output);

        $composerJson = (new JsonFile(sprintf('%s/composer.json', $this->kernel->getProjectDir())))->read();
        $bundleComposerJson = (new JsonFile(sprintf('%s/vendor/%s/composer.json', $this->kernel->getProjectDir(), $command->package)))->read();

        foreach ($bundleComposerJson['require'] as $package => $version) {
            if(Bundles::isZentlixBundle($package) && !isset($composerJson['require'][$package])) {
                $application->run(new ArrayInput([
                    'command'       => 'require',
                    'packages'      => [$package],
                    '--working-dir' => $this->kernel->getProjectDir()
                ]), $output);
            }
        }

        $application = new SymfonyApplication($this->kernel);
        $application->setAutoExit(false);

        $application->run(new ArrayInput(['command' => 'cache:clear', '--no-warmup' => true]), new NullOutput());

        $this->logger->info($output->fetch());
    }
}