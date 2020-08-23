<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Bundle\Event\AfterInstall;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;
use Zentlix\MainBundle\Application\Command;
use Zentlix\MainBundle\Domain\Setting\Entity\Setting;
use Zentlix\MainBundle\MainBundle;

class InstallBundleSubscriber implements EventSubscriberInterface
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

    public static function getSubscribedEvents(): array
    {
        return [
            AfterInstall::class => 'onAfterInstall',
        ];
    }

    public function onAfterInstall(AfterInstall $afterInstall): void
    {
        /** @var Bundle $bundle */
        $bundle = $afterInstall->getBundle();

        if($bundle->getClass() === MainBundle::class) {
            $command = new Command\Locale\CreateCommand();
            $command->title = 'Русский';
            $command->code = 'ru';
            $command->icon = 'flag-icon-ru';
            $command->sort = 500;

            $this->commandBus->handle($command);

            $command = new Command\Locale\CreateCommand();
            $command->title = 'Українська';
            $command->code = 'ua';
            $command->icon = 'flag-icon-ua';
            $command->sort = 500;

            $this->commandBus->handle($command);

            $this->entityManager->persist(new Setting($this->localeRepository->getOneByCode($this->defaultLocale)));

            $command = new Command\Template\CreateCommand();
            $command->title = $this->translator->trans('zentlix_main.default_template');
            $command->folder = 'default';
            $this->commandBus->handle($command);

            $this->entityManager->flush();
        }
    }
}