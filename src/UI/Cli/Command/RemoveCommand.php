<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Cli\Command;

use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Zentlix\MainBundle\Application\Command\Bundle\Zentlix\RemoveCommand as RemoveBundleCommand;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;

use function get_class;

class RemoveCommand extends ConsoleCommand {

    public function __construct(
        private CommandBus $commandBus,
        private Bundles $bundles,
        private BundleRepository $bundleRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('zentlix_main:remove')
            ->setDescription('Removing public Zentlix bundle files, configuration from the application.')
            ->addArgument('bundle', InputArgument::REQUIRED, 'Bundle name, e.g. zentlix/shop-bundle');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $package = $input->getArgument('bundle');
        $io = new SymfonyStyle($input, $output);

        try {
            $this->removeBundle($package, $io);
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());

            return self::FAILURE;
        }

        $io->success(sprintf('Bundle %s successfully removed!', $package));

        return self::SUCCESS;
    }

    private function removeBundle(string $package, SymfonyStyle $io): void
    {
        $bundle = $this->bundles->getByPackageName($package);
        $entity = $this->bundleRepository->getOneByClass(get_class($bundle));

        $io->comment(sprintf('Removing <info>%s</info>', $bundle->getBundleName()));

        $this->commandBus->handle(new RemoveBundleCommand($entity));
    }
}