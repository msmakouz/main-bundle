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
        $this->files->CleaningGarbage();

        $output->writeln('<info>Unused files succesfully deleted. </info>');

        return 1;
    }
}