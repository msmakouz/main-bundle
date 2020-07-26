<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Locale;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Application\Command\CommandHandlerInterface;
use Zentlix\MainBundle\Domain\Locale\Event\AfterCreate;
use Zentlix\MainBundle\Domain\Locale\Event\BeforeCreate;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Domain\Locale\Specification\UniqueCodeSpecification;

class CreateHandler implements CommandHandlerInterface
{
    private UniqueCodeSpecification $uniqueCodeSpecification;
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(UniqueCodeSpecification $uniqueCodeSpecification, EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->uniqueCodeSpecification = $uniqueCodeSpecification;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(CreateCommand $command): void
    {
        $this->uniqueCodeSpecification->isUnique($command->code);

        $this->eventDispatcher->dispatch(new BeforeCreate($command));

        $locale = new Locale($command);

        $this->entityManager->persist($locale);
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterCreate($locale, $command));
    }
}