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
use Zentlix\MainBundle\Domain\Bundle\Event\AfterRemove;
use Zentlix\MainBundle\Domain\Bundle\Event\BeforeRemove;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;
use Zentlix\MainBundle\Domain\Bundle\Service\Installer;
use Zentlix\MainBundle\Domain\Bundle\Specification\ExistByClassBundleSpecification;
use Zentlix\MainBundle\Domain\Bundle\Specification\IsNotSystemSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;
use function get_class;

class RemoveHandler implements CommandHandlerInterface
{
    private EventDispatcherInterface $eventDispatcher;
    private EntityManagerInterface $entityManager;
    private ExistByClassBundleSpecification $existByClassBundleSpecification;
    private IsNotSystemSpecification $isNotSystemSpecification;
    private BundleRepository $bundleRepository;
    private Installer $installer;

    public function __construct(EventDispatcherInterface $eventDispatcher,
                                EntityManagerInterface $entityManager,
                                BundleRepository $bundleRepository,
                                ExistByClassBundleSpecification $existByClassBundleSpecification,
                                IsNotSystemSpecification $isNotSystemSpecification,
                                Installer $installer)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->entityManager = $entityManager;
        $this->existByClassBundleSpecification = $existByClassBundleSpecification;
        $this->isNotSystemSpecification = $isNotSystemSpecification;
        $this->bundleRepository = $bundleRepository;
        $this->installer = $installer;
    }

    public function __invoke(RemoveCommand $command): void
    {
        $this->existByClassBundleSpecification->isExist(get_class($command->getBundle()));
        $bundle = $this->bundleRepository->getOneByClass(get_class($command->getBundle()));
        $this->isNotSystemSpecification->isNotSystem($bundle->getId());
        $class = $bundle->getClass();

        $this->eventDispatcher->dispatch(new BeforeRemove($command));

        $this->installer->remove($command->getBundle());

        $this->entityManager->remove($bundle);
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterRemove($class));
    }
}