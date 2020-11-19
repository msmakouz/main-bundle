<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Cli\Command;

use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Zentlix\MainBundle\Application\Command\Bundle\Zentlix\InstallCommand as InstallBundleCommand;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;

class InstallCommand extends ConsoleCommand {

    private CommandBus $commandBus;
    private Bundles $bundles;

    public function __construct(CommandBus $commandBus, Bundles $bundles)
    {
        parent::__construct();

        $this->bundles = $bundles;
        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setName('zentlix_main:install')
            ->setDescription('Copying configuration files, public files to the application.')
            ->addArgument('bundle', InputArgument::OPTIONAL, 'Bundle name, e.g. zentlix/shop-bundle');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $package = $input->getArgument('bundle');
        $io = new SymfonyStyle($input, $output);

        try {
            if($package) {
                $this->installSingleBundle($package, $io);
            } else {
                $this->installCMS($io);
            }
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());

            return 1;
        }

        $io->success(sprintf('%s successfully installed!', $package ? sprintf('Bundle %s', $package) : 'Zentlix CMS'));

        return 0;
    }

    private function installSingleBundle(string $package, SymfonyStyle $io): void
    {
        $bundle = $this->bundles->getByPackageName($package);

        $io->comment(sprintf('Installing <info>%s</info>', $bundle->getBundleName()));

        $this->commandBus->handle(new InstallBundleCommand($bundle));
    }

    private function installCMS(SymfonyStyle $io): void
    {
        $bundles = $this->bundles->getBundles();

        foreach ($bundles as $bundle) {
            $io->comment(sprintf('Installing <info>%s</info>', $bundle->getBundleName()));
            $this->commandBus->handle(new InstallBundleCommand($bundle));
        }
    }
}