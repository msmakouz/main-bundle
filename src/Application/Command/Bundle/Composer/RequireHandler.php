<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle\Composer;

use Composer\Console\Application;
use Composer\Json\JsonFile;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class RequireHandler implements CommandHandlerInterface
{
    public function __construct(
        private KernelInterface $kernel,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(RequireCommand $command): void
    {
        set_time_limit(0);

        $application = new Application();
        $application->setAutoExit(false);
        $output = new BufferedOutput();

        $application->run(new ArrayInput([
            'command' => 'require',
            'packages' => [$command->package],
            '--working-dir' => $this->kernel->getProjectDir(),
        ]), $output);

        $composerJson = (new JsonFile(sprintf('%s/composer.json', $this->kernel->getProjectDir())))->read();
        $bundleComposerJson = (
            new JsonFile(sprintf('%s/vendor/%s/composer.json', $this->kernel->getProjectDir(), $command->package))
        )->read();

        foreach ($bundleComposerJson['require'] as $package => $version) {
            if (Bundles::isZentlixBundle($package) && !isset($composerJson['require'][$package])) {
                $application->run(new ArrayInput([
                    'command' => 'require',
                    'packages' => [$package],
                    '--working-dir' => $this->kernel->getProjectDir(),
                ]), $output);
            }
        }

        $application = new SymfonyApplication($this->kernel);
        $application->setAutoExit(false);

        $application->run(new ArrayInput(['command' => 'cache:clear', '--no-warmup' => true]), new NullOutput());

        $this->logger->info($output->fetch());
    }
}
