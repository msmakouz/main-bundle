<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Template;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Attribute\Service\Attributes;
use Zentlix\MainBundle\Domain\Cache\Service\Cache;
use Zentlix\MainBundle\Domain\Template\Event\AfterUpdate;
use Zentlix\MainBundle\Domain\Template\Event\BeforeUpdate;
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
        $template = $command->getEntity();

        $this->eventDispatcher->dispatch(new BeforeUpdate($command));

        $this->attributes->saveValues($template, $command->attributes);
        Cache::clear(Cache::TEMPLATE_ATTRIBUTE_VALUES);

        $template->update($command);

        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterUpdate($template, $command));
    }
}
