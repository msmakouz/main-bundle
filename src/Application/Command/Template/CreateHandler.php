<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Template;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Attribute\Service\Attributes;
use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\Domain\Template\Event\AfterCreate;
use Zentlix\MainBundle\Domain\Template\Event\BeforeCreate;
use Zentlix\MainBundle\Domain\Template\Specification\ExistFolderSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class CreateHandler implements CommandHandlerInterface
{
    public function __construct(
        private ExistFolderSpecification $existFolderSpecification,
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private Attributes $attributes
    ) {
    }

    public function __invoke(CreateCommand $command): void
    {
        $this->existFolderSpecification->isExist($command->folder);

        $this->eventDispatcher->dispatch(new BeforeCreate($command));

        $template = new Template($command);

        $this->entityManager->persist($template);
        $this->entityManager->flush();

        $this->attributes->saveValues($template, $command->attributes);

        $this->eventDispatcher->dispatch(new AfterCreate($template, $command));
    }
}
