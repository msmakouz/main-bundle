<?php

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

class InstallHandler implements CommandHandlerInterface
{
    public function __construct(
        private UniqueClassSpecification $uniqueClassSpecification,
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private Installer $installer
    ) {
    }

    public function __invoke(InstallCommand $command): void
    {
        $this->uniqueClassSpecification->isUnique($command->getBundle()::class);

        $this->eventDispatcher->dispatch(new BeforeInstall($command));

        $bundle = new Bundle($command);

        $this->entityManager->persist($bundle);

        $this->installer->install($command->getBundle());

        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterInstall($bundle));
    }
}
