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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Zentlix\MainBundle\Domain\File\Service\Files;

class DeleteFilesCommand extends Command
{
    private Files $files;

    public function __construct(Files $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    protected function configure(): void
    {
        $this
            ->setName('zentlix_main:cron:deleting-files')
            ->setDescription('Deleting unused files from storage and database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->files->CleaningGarbage();

        $io->success('Unused files successfully deleted.');

        return 0;
    }
}