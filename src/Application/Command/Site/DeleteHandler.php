<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Site;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Attribute\Service\Attributes;
use Zentlix\MainBundle\Domain\Site\Event\AfterDelete;
use Zentlix\MainBundle\Domain\Site\Event\BeforeDelete;
use Zentlix\MainBundle\Domain\Site\Service\Sites;
use Zentlix\MainBundle\Domain\Site\Specification\NotSingleSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class DeleteHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private NotSingleSpecification $notSingleSpecification,
        private Attributes $attributes
    ) {
    }

    public function __invoke(DeleteCommand $command): void
    {
        $this->notSingleSpecification->isNotSingle();

        $siteId = $command->site->getId();

        $this->eventDispatcher->dispatch(new BeforeDelete($command));

        $this->attributes->removeValues($siteId);

        $this->entityManager->remove($command->site);
        $this->entityManager->flush();

        Sites::clearCache();

        $this->eventDispatcher->dispatch(new AfterDelete($siteId));
    }
}
