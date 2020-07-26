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
use Symfony\Component\Console\Question\Question;
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
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = new CreateCommand();

        $command->title = $input->getArgument('title');

        $helper = $this->getHelper('question');

        $question = new Question('Locale code:');
        $command->code = $helper->ask($input, $output, $question);

        $question = new Question('Locale sort:', 500);
        $command->sort = (int) $helper->ask($input, $output, $question);

        $question = new Question('Locale icon class:');
        $command->icon = $helper->ask($input, $output, $question);

        $this->commandBus->handle($command);

        $output->writeln('<info>Locale was created: </info>');
        $output->writeln('');
        $output->writeln("Title: $command->title");
        $output->writeln("Code: $command->code");
        $output->writeln("Sort: $command->sort");
        $output->writeln("Icon class: $command->icon");
    }
}