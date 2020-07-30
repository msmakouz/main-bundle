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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;
use Zentlix\MainBundle\Application\Command\CommandHandlerInterface;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Bundle\Event\AfterInstall;
use Zentlix\MainBundle\Domain\Bundle\Event\BeforeInstall;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Domain\Bundle\Specification\UniqueClassSpecification;

class InstallHandler implements CommandHandlerInterface
{
    private const ROUTES_CONFIG_DIR = '/config/routes/';
    private const PUBLIC_DIR = '/public/zentlix/';

    private UniqueClassSpecification $uniqueClassSpecification;
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;
    private Filesystem $filesystem;
    private KernelInterface $kernel;
    private Bundles $bundles;

    public function __construct(UniqueClassSpecification $uniqueClassSpecification,
                                EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher,
                                Filesystem $filesystem,
                                KernelInterface $kernel,
                                Bundles $bundles)
    {
        $this->uniqueClassSpecification = $uniqueClassSpecification;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->filesystem = $filesystem;
        $this->bundles = $bundles;
        $this->kernel = $kernel;
    }

    public function __invoke(InstallCommand $command): void
    {
        $this->uniqueClassSpecification->isUnique(get_class($command->getBundle()));

        $this->eventDispatcher->dispatch(new BeforeInstall($command));

        $bundle = new Bundle($command);

        $this->entityManager->persist($bundle);

        $this->copyRoutes(get_class($command->getBundle()));
        $this->copyPublicFiles(get_class($command->getBundle()));
        $this->copyTemplates(get_class($command->getBundle()));

        foreach ($command->getBundle()->installMailerEvents() as $mailerEvent) {
            $mailerEvent->setBundle($bundle);
            $this->entityManager->persist($mailerEvent);
        }

        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterInstall($bundle));
    }

    private function copyRoutes($class): void
    {
        $reflector = new \ReflectionClass($class);
        $finder = new Finder();
        $resource = $this->kernel->locateResource(sprintf('@%s/Resources/', $reflector->getShortName()));
        if(is_dir($resource . 'global/routes')) {
            $routes = $finder->files()->in($resource . 'global/routes');
            if($routes->hasResults()) {
                foreach ($finder as $file) {
                    $routes = $this->kernel->getProjectDir() . self::ROUTES_CONFIG_DIR . $file->getFilename();
                    $this->filesystem->copy($file->getRealPath(), $routes);
                }
            }
        }
    }

    private function copyPublicFiles($class): void
    {
        $reflector = new \ReflectionClass($class);
        $resource = $this->kernel->locateResource(sprintf('@%s/Resources/', $reflector->getShortName()));

        if(is_dir($resource . 'global/public')) {
            $this->filesystem->mirror($resource . 'global/public', $this->kernel->getProjectDir() . self::PUBLIC_DIR);
        }
    }

    private function copyTemplates($class): void
    {
        $reflector = new \ReflectionClass($class);
        $resource = $this->kernel->locateResource(sprintf('@%s/Resources/', $reflector->getShortName()));

        if(is_dir($resource . 'global/templates')) {
            $this->filesystem->mirror($resource . 'global/templates', $this->kernel->getProjectDir() . '/templates/');
        }
    }
}