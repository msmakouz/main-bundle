<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Bundle\Event\AfterInstall;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;
use Zentlix\MainBundle\Application\Command;
use Zentlix\MainBundle\Domain\Setting\Entity\Setting;
use Zentlix\MainBundle\MainBundle;

class BundleListener
{
    private EntityManagerInterface $entityManager;
    private CommandBus $commandBus;
    private TranslatorInterface $translator;
    private LocaleRepository $localeRepository;
    private string $defaultLocale;

    public function __construct(CommandBus $commandBus,
                                TranslatorInterface $translator,
                                EntityManagerInterface $entityManager,
                                LocaleRepository $localeRepository,
                                string $defaultLocale)
    {
        $this->entityManager = $entityManager;
        $this->commandBus = $commandBus;
        $this->translator = $translator;
        $this->localeRepository = $localeRepository;
        $this->defaultLocale = $defaultLocale;
    }

    public function __invoke(AfterInstall $afterInstall): void
    {
        /** @var Bundle $bundle */
        $bundle = $afterInstall->getBundle();

        if($bundle->getClass() === MainBundle::class) {
            $this->createLocales();
            $this->createTemplate();
            $this->createMainBundleSettings();
        }
    }

    private function createLocales(): void
    {
        $command = new Command\Locale\CreateCommand();
        $command->title = 'Русский';
        $command->code = 'ru';
        $command->icon = 'flag-icon-ru';

        $this->commandBus->handle($command);

        $command = new Command\Locale\CreateCommand();
        $command->title = 'Українська';
        $command->code = 'ua';
        $command->icon = 'flag-icon-ua';

        $this->commandBus->handle($command);
    }

    private function createTemplate(): void
    {
        $command = new Command\Template\CreateCommand();
        $command->title = $this->translator->trans('zentlix_main.default_template');
        $command->folder = 'default';
        $this->commandBus->handle($command);
    }

    private function createMainBundleSettings(): void
    {
        $this->entityManager->persist(new Setting($this->localeRepository->getOneByCode($this->defaultLocale)));
        $this->entityManager->flush();
    }
}