<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Setting;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Application\Command\CommandHandlerInterface;
use Zentlix\MainBundle\Domain\Locale\Specification\ExistLocaleSpecification;
use Zentlix\MainBundle\Domain\Setting\Event\AfterChange;
use Zentlix\MainBundle\Domain\Setting\Event\BeforeChange;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;

class SettingHandler implements CommandHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;
    private ExistLocaleSpecification $existLocaleSpecification;
    private LocaleRepository $localeRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher,
                                ExistLocaleSpecification $existLocaleSpecification,
                                LocaleRepository $localeRepository)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->existLocaleSpecification = $existLocaleSpecification;
        $this->localeRepository = $localeRepository;
    }

    public function __invoke(SettingCommand $command): void
    {
        $settings = $command->getSettings();

        $this->existLocaleSpecification->isExist($command->default_locale);
        $command->default_locale = $this->localeRepository->get($command->default_locale);

        $this->eventDispatcher->dispatch(new BeforeChange($settings));

        $settings->change($command);

        $this->eventDispatcher->dispatch(new AfterChange($settings));

        $this->entityManager->flush();
    }
}