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
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Output\OutputInterface;
use Zentlix\MainBundle\Application\Command\Locale\CreateCommand;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;

class CreateLocaleCommand extends ConsoleCommand {

    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();

        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setName('zentlix_main:create:locale')
            ->setDescription('Given a title, code, sort generates a new locale.')
            ->addArgument('title', InputArgument::REQUIRED, 'Locale title');
    }

    /** @throws \Exception */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $command = new CreateCommand();

        $command->title = $input->getArgument('title');
        $command->code = (string) $io->ask('Locale code', null, function ($code) {
            if (empty($code)) {
                throw new \RuntimeException('Locale code cannot be empty.');
            }

            return $code;
        });
        $command->sort = (int) $io->ask('Locale sort', 1, function ($sort) {
            if ((int) $sort < 1) {
                throw new \RuntimeException('Locale sort must be a positive int.');
            }

            return $sort;
        });
        $command->icon = (string) $io->ask('Locale icon class');

        try {
            $this->commandBus->handle($command);
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());

            return 1;
        }

        $io->success('Locale was created!');
        $io->text([
            "Title: $command->title",
            "Code: $command->code",
            "Sort: $command->sort",
            "Icon class: $command->icon"
        ]);

        return 0;
    }
}