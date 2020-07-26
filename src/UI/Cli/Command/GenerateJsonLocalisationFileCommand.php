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
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;
use Zentlix\MainBundle\Application\Command\Locale\JsonCommand;

class GenerateJsonLocalisationFileCommand extends Command
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();

        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setName('zentlix_main:generate:json-localization-file')
            ->setDescription('Generate json localization file for Angular admin frontend.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandBus->handle(new JsonCommand());

        $output->writeln('<info>Localisation files generated succesfully. </info>');

        return 1;
    }
}