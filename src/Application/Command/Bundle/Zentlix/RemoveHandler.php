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
use Zentlix\MainBundle\Domain\Bundle\Event\AfterRemove;
use Zentlix\MainBundle\Domain\Bundle\Event\BeforeRemove;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Domain\Bundle\Service\Installer;
use Zentlix\MainBundle\Domain\Bundle\Specification\ExistBundleSpecification;
use Zentlix\MainBundle\Domain\Bundle\Specification\IsNotRequiredSpecification;
use Zentlix\MainBundle\Domain\Bundle\Specification\IsNotSystemSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class RemoveHandler implements CommandHandlerInterface
{
    private EventDispatcherInterface $eventDispatcher;
    private EntityManagerInterface $entityManager;
    private Bundles $bundles;
    private IsNotRequiredSpecification $isNotRequiredSpecification;
    private ExistBundleSpecification $existBundleSpecification;
    private IsNotSystemSpecification $isNotSystemSpecification;
    private Installer $installer;

    public function __construct(EventDispatcherInterface $eventDispatcher,
                                EntityManagerInterface $entityManager,
                                Bundles $bundles,
                                ExistBundleSpecification $existBundleSpecification,
                                IsNotSystemSpecification $isNotSystemSpecification,
                                IsNotRequiredSpecification $isNotRequiredSpecification,
                                Installer $installer)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->entityManager = $entityManager;
        $this->bundles = $bundles;
        $this->existBundleSpecification = $existBundleSpecification;
        $this->isNotSystemSpecification = $isNotSystemSpecification;
        $this->isNotRequiredSpecification = $isNotRequiredSpecification;
        $this->installer = $installer;
    }

    public function __invoke(RemoveCommand $command): void
    {
        $this->existBundleSpecification->isExist($command->getBundle()->getId());
        $this->isNotSystemSpecification->isNotSystem($command->getBundle()->getId());
        $this->isNotRequiredSpecification->isNotRequired($this->bundles->getByClass($command->getBundle()->getClass())->getBundleName());

        $this->eventDispatcher->dispatch(new BeforeRemove($command));

        $class = $command->getBundle()->getClass();

        $this->installer->remove($this->bundles->getByClass($command->getBundle()->getClass()));

        $this->entityManager->remove($command->getBundle());
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterRemove($class));
    }
}