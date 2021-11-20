<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Cli\Command;

use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Zentlix\MainBundle\Application\Command\Template\CreateCommand;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;

class CreateTemplateCommand extends ConsoleCommand
{
    public function __construct(
        private CommandBus $commandBus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('zentlix_main:create:template')
            ->setDescription('Given a title, folder, sort generates a new template.')
            ->addArgument('title', InputArgument::REQUIRED, 'Template title');
    }

    /** @throws \Exception */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $command = new CreateCommand();

        $command->title = $input->getArgument('title');
        $command->folder = (string) $io->ask('Template folder', null, function ($folder) {
            if (empty($folder)) {
                throw new \RuntimeException('Template folder cannot be empty.');
            }

            return $folder;
        });
        $command->sort = (int) $io->ask('Template sort', '1', function ($sort) {
            if ((int) $sort < 1) {
                throw new \RuntimeException('Template sort must be a positive int.');
            }

            return $sort;
        });

        try {
            $this->commandBus->handle($command);
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());

            return 1;
        }

        $io->success('Template was created!');
        $io->text([
            "Title: $command->title",
            "Folder: $command->folder",
            "Sort: $command->sort"
        ]);

        return self::SUCCESS;
    }
}