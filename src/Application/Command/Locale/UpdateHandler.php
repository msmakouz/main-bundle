<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Locale;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Attribute\Service\Attributes;
use Zentlix\MainBundle\Domain\Locale\Event\AfterUpdate;
use Zentlix\MainBundle\Domain\Locale\Event\BeforeUpdate;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class UpdateHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private Attributes $attributes
    ) {
    }

    public function __invoke(UpdateCommand $command): void
    {
        $locale = $command->getEntity();

        $this->eventDispatcher->dispatch(new BeforeUpdate($command));

        $this->attributes->saveValues($locale, $command->attributes);

        $locale->update($command);

        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterUpdate($locale, $command));
    }
}
