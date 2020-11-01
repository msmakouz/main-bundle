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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class CreateHtaccessCommand extends ConsoleCommand {

    private Filesystem $filesystem;
    private KernelInterface $kernel;

    public function __construct(Filesystem $filesystem, KernelInterface $kernel)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
        $this->kernel = $kernel;
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
    }
}