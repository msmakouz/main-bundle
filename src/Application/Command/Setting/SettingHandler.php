<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Setting;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\MainBundle\Domain\Locale\Specification\ExistLocaleSpecification;
use Zentlix\MainBundle\Domain\Setting\Event\AfterChange;
use Zentlix\MainBundle\Domain\Setting\Event\BeforeChange;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class SettingHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private ExistLocaleSpecification $existLocaleSpecification,
        private LocaleRepository $localeRepository
    ) {
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
