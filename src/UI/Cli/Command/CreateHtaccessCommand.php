<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Cli\Command;

use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class CreateHtaccessCommand extends ConsoleCommand {

    public function __construct(
        private Filesystem $filesystem,
        private KernelInterface $kernel
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('zentlix_main:configure:htaccess')
            ->setDescription('Create default .htaccess file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->filesystem->copy(
            $this->kernel->locateResource('@MainBundle/Resources/global/.htaccess'),
            $this->kernel->getProjectDir() . '/public/.htaccess'
        );

        $io->success('Htaccess file created successfully!');

        return self::SUCCESS;
    }
}
