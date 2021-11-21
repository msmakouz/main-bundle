<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Zentlix\MainBundle\Domain\File\Service\Files;

class DeleteFilesCommand extends Command
{
    public function __construct(
        private Files $files
    ) {
        parent::__construct();
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

        $this->files->cleaningGarbage();

        $io->success('Unused files successfully deleted.');

        return self::SUCCESS;
    }
}
