<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Attribute;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\Attribute\Event\AfterCreate;
use Zentlix\MainBundle\Domain\Attribute\Event\BeforeCreate;
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;
use Zentlix\MainBundle\Domain\Attribute\Specification\UniqueCodeSpecification;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;
use Zentlix\MainBundle\Domain\Bundle\Specification\ExistByClassBundleSpecification;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class CreateHandler implements CommandHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;
    private UniqueCodeSpecification $uniqueCodeSpecification;
    private ExistByClassBundleSpecification $existByClassBundleSpecification;
    private BundleRepository $bundleRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher,
                                UniqueCodeSpecification $uniqueCodeSpecification,
                                ExistByClassBundleSpecification $existByClassBundleSpecification,
                                BundleRepository $bundleRepository)
    {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->uniqueCodeSpecification = $uniqueCodeSpecification;
        $this->existByClassBundleSpecification = $existByClassBundleSpecification;
        $this->bundleRepository = $bundleRepository;
    }

    public function __invoke(CreateCommand $command): void
    {
        if($command->code) {
            $this->uniqueCodeSpecification->isUnique($command->code, $command->attributeEntity);
        }
        $this->existByClassBundleSpecification->isExist($command->bundle);
        $command->bundle = $this->bundleRepository->getOneByClass($command->bundle);

        $this->eventDispatcher->dispatch(new BeforeCreate($command));

        $attribute = new Attribute($command);

        $this->entityManager->persist($attribute);
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterCreate($attribute, $command));
    }
}