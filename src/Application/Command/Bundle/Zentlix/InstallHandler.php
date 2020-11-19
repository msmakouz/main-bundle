<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle\Zentlix;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Bundle\Event\AfterInstall;
use Zentlix\MainBundle\Domain\Bundle\Event\BeforeInstall;
use Zentlix\MainBundle\Domain\Bundle\Service\Installer;
use Zentlix\MainBundle\Domain\Bundle\Specification\UniqueClassSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;
use function get_class;

class InstallHandler implements CommandHandlerInterface
{
    private UniqueClassSpecification $uniqueClassSpecification;
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;
    private Installer $installer;

    public function __construct(UniqueClassSpecification $uniqueClassSpecification,
                                EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher,
                                Installer $installer)
    {
        $this->uniqueClassSpecification = $uniqueClassSpecification;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->installer = $installer;
    }

    public function __invoke(InstallCommand $command): void
    {
        $this->uniqueClassSpecification->isUnique(get_class($command->getBundle()));

        $this->eventDispatcher->dispatch(new BeforeInstall($command));

        $bundle = new Bundle($command);

        $this->entityManager->persist($bundle);

        $this->installer->install($command->getBundle());

        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterInstall($bundle));
    }
}