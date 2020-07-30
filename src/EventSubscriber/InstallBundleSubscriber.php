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
use Zentlix\MainBundle\Application\Command\Locale\CreateCommand;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Domain\Setting\Entity\Setting;
use Zentlix\MainBundle\Domain\Site\Entity\Template;
use Zentlix\MainBundle\MainBundle;

class InstallBundleSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;
    private TranslatorInterface $translator;
    private string $defaultLocale;

    public function __construct(EntityManagerInterface $entityManager, TranslatorInterface $translator, string $defaultLocale)
    {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
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
            $locales = [];

            $command = new CreateCommand();
            $command->title = 'Русский';
            $command->code = 'ru';
            $command->icon = 'flag-icon-ru';
            $command->sort = 500;
            $locales[$command->code] = new Locale($command);

            $this->entityManager->persist($locales[$command->code]);

            $command = new CreateCommand();
            $command->title = 'Українська';
            $command->code = 'ua';
            $command->icon = 'flag-icon-ua';
            $command->sort = 500;
            $locales[$command->code] = new Locale($command);

            $this->entityManager->persist($locales[$command->code]);
            $this->entityManager->persist(new Setting($locales[$this->defaultLocale]));

            $this->entityManager->persist(new Template($this->translator->trans('zentlix_main.default_template'), 'default'));

            $this->entityManager->flush();
        }
    }
}