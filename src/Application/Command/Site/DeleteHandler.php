<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Site;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Site\Event\Site\BeforeDelete;
use Zentlix\MainBundle\Domain\Site\Event\Site\AfterDelete;
use Zentlix\MainBundle\Domain\Site\Specification\NotSingleSpecification;
use Zentlix\MainBundle\Domain\Site\Service\Sites;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class DeleteHandler implements CommandHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;
    private NotSingleSpecification $notSingleSpecification;

    public function __construct(EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher,
                                NotSingleSpecification $notSingleSpecification)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->notSingleSpecification = $notSingleSpecification;
    }

    public function __invoke(DeleteCommand $command): void
    {
        $this->notSingleSpecification->isNotSingle();

        $siteId = $command->site->getId();

        $this->eventDispatcher->dispatch(new BeforeDelete($command));

        $this->entityManager->remove($command->site);
        $this->entityManager->flush();

        Sites::clearCache();

        $this->eventDispatcher->dispatch(new AfterDelete($siteId));
    }
}