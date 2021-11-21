<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Locale;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Attribute\Service\Attributes;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Domain\Locale\Event\AfterCreate;
use Zentlix\MainBundle\Domain\Locale\Event\BeforeCreate;
use Zentlix\MainBundle\Domain\Locale\Specification\UniqueCodeSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class CreateHandler implements CommandHandlerInterface
{
    public function __construct(
        private UniqueCodeSpecification $uniqueCodeSpecification,
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private Attributes $attributes
    ) {
    }

    public function __invoke(CreateCommand $command): void
    {
        $this->uniqueCodeSpecification->isUnique($command->code);

        $this->eventDispatcher->dispatch(new BeforeCreate($command));

        $locale = new Locale($command);

        $this->entityManager->persist($locale);
        $this->entityManager->flush();

        $this->attributes->saveValues($locale, $command->attributes);

        $this->eventDispatcher->dispatch(new AfterCreate($locale, $command));
    }
}
