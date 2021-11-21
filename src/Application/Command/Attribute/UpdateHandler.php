<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Attribute;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Attribute\Event\AfterUpdate;
use Zentlix\MainBundle\Domain\Attribute\Event\BeforeUpdate;
use Zentlix\MainBundle\Domain\Attribute\Specification\UniqueCodeSpecification;
use Zentlix\MainBundle\Domain\Cache\Service\Cache;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class UpdateHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private UniqueCodeSpecification $uniqueCodeSpecification
    ) {
    }

    public function __invoke(UpdateCommand $command): void
    {
        $attribute = $command->getEntity();

        if (!$attribute->isCodeEqual($command->code)) {
            $this->uniqueCodeSpecification->isUnique($command->code, $attribute->getEntity());
        }

        $this->eventDispatcher->dispatch(new BeforeUpdate($command));

        $attribute->update($command);

        $this->entityManager->flush();

        Cache::clear(Cache::ATTRIBUTES);

        $this->eventDispatcher->dispatch(new AfterUpdate($attribute, $command));
    }
}
