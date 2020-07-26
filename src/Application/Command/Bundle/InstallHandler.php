<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Application\Command\CommandHandlerInterface;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Bundle\Event\AfterInstall;
use Zentlix\MainBundle\Domain\Bundle\Event\BeforeInstall;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Domain\Bundle\Specification\UniqueClassSpecification;

class InstallHandler implements CommandHandlerInterface
{
    private UniqueClassSpecification $uniqueClassSpecification;
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;
    private Bundles $bundles;

    public function __construct(UniqueClassSpecification $uniqueClassSpecification,
                                EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher,
                                Bundles $bundles)
    {
        $this->uniqueClassSpecification = $uniqueClassSpecification;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->bundles = $bundles;
    }

    public function __invoke(InstallCommand $command): void
    {
        $this->uniqueClassSpecification->isUnique($command->getClass());

        $bundleObject = $this->bundles->getByClass($command->getClass());

        $this->eventDispatcher->dispatch(new BeforeInstall($command));

        $bundle = new Bundle($command);

        $this->entityManager->persist($bundle);
        $this->entityManager->flush();

        $bundleObject->install();

        $this->eventDispatcher->dispatch(new AfterInstall($bundle));
    }
}