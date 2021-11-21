<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Cli\Command;

use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Zentlix\MainBundle\Application\Command\Site\CreateCommand;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\MainBundle\Domain\Template\Repository\TemplateRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;

class CreateSiteCommand extends ConsoleCommand
{
    public function __construct(
        private CommandBus $commandBus,
        private TemplateRepository $templateRepository,
        private LocaleRepository $localeRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('zentlix_main:create:site')
            ->setDescription('Given a url, title generates a new site.')
            ->addArgument('url', InputArgument::REQUIRED, 'Site URL');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $templates = $this->templateRepository->assoc();
        $locales = $this->localeRepository->assoc();

        $command = new CreateCommand();

        $command->url = $input->getArgument('url');
        $command->title = $io->ask('Site title', null, function ($title) {
            if (empty($title)) {
                throw new \RuntimeException('Site title cannot be empty.');
            }

            return $title;
        });

        $template = $io->choice('Please, select template', $templates);
        $locale = $io->choice('Please, select language', $locales);

        $command->template = $template;
        $command->locale = $locale;
        $metaTitle = (string) $io->ask('Meta title');
        $metaDescription = (string) $io->ask('Meta description');
        $metaKeywords = (string) $io->ask('Meta keywords');

        $command->setMetaTitle($metaTitle);
        $command->setMetaDescription($metaDescription);
        $command->setMetaKeywords($metaKeywords);

        $command->sort = (int) $io->ask('Sort', '1');

        try {
            $this->commandBus->handle($command);
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());

            return 1;
        }

        $io->success('Site was created!');

        $io->text([
            "URL: $command->url",
            "Title: $command->title",
            sprintf('Template: %s', $command->template->getTitle()),
            sprintf('Language: %s', $command->locale->getTitle()),
            sprintf('Meta title: %s', $command->getMetaTitle()),
            sprintf('Meta description: %s', $command->getMetaDescription()),
            sprintf('Meta keywords: %s', $command->getMetaKeywords()),
            "Sort: $command->sort",
        ]);

        return self::SUCCESS;
    }
}
