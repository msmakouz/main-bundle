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
use Zentlix\MainBundle\Domain\Locale\Event\BeforeUpdate;
use Zentlix\MainBundle\Domain\Locale\Event\AfterUpdate;

class UpdateHandler implements CommandHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(UpdateCommand $command): void
    {
        $locale = $command->getEntity();

        $this->eventDispatcher->dispatch(new BeforeUpdate($command));

        $locale->update($command);

        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterUpdate($locale, $command));
    }
}