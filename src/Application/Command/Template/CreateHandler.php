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
use Zentlix\MainBundle\Domain\Site\Event\Template\AfterCreate;
use Zentlix\MainBundle\Domain\Site\Event\Template\BeforeCreate;
use Zentlix\MainBundle\Domain\Site\Entity\Template;
use Zentlix\MainBundle\Domain\Site\Specification\ExistTemplateFolderSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class CreateHandler implements CommandHandlerInterface
{
    private ExistTemplateFolderSpecification $existTemplateFolderSpecification;
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(ExistTemplateFolderSpecification $existTemplateFolderSpecification,
                                EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->existTemplateFolderSpecification = $existTemplateFolderSpecification;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(CreateCommand $command): void
    {
        $this->existTemplateFolderSpecification->isExist($command->folder);

        $this->eventDispatcher->dispatch(new BeforeCreate($command));

        $template = new Template($command);

        $this->entityManager->persist($template);
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterCreate($template, $command));
    }
}