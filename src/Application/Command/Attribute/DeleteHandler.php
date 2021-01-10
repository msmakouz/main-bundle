<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Attribute;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Attribute\Event\BeforeDelete;
use Zentlix\MainBundle\Domain\Attribute\Event\AfterDelete;
use Zentlix\MainBundle\Domain\Cache\Service\Cache;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class DeleteHandler implements CommandHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(DeleteCommand $command): void
    {
        $attributeId = $command->attribute->getId();

        $this->eventDispatcher->dispatch(new BeforeDelete($command));

        foreach ($command->attribute->getValues()->getValues() as $value) {
            $this->entityManager->remove($value);
        }

        $this->entityManager->remove($command->attribute);
        $this->entityManager->flush();

        Cache::clear(Cache::ATTRIBUTES);

        $this->eventDispatcher->dispatch(new AfterDelete($attributeId));
    }
}