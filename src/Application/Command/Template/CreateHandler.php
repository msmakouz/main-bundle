<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Template;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Attribute\Service\Attributes;
use Zentlix\MainBundle\Domain\Template\Event\AfterCreate;
use Zentlix\MainBundle\Domain\Template\Event\BeforeCreate;
use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\Domain\Template\Specification\ExistFolderSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class CreateHandler implements CommandHandlerInterface
{
    private ExistFolderSpecification $existFolderSpecification;
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;
    private Attributes $attributes;

    public function __construct(ExistFolderSpecification $existFolderSpecification,
                                EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher,
                                Attributes $attributes)
    {
        $this->existFolderSpecification = $existFolderSpecification;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->attributes = $attributes;
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