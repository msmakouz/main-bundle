<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\ZentlixBundleInterface;

class Installer
{
    private EntityManagerInterface $entityManager;
    private KernelInterface $kernel;
    private Filesystem $filesystem;

    public function __construct(KernelInterface $kernel, Filesystem $filesystem, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->kernel = $kernel;
        $this->filesystem = $filesystem;
    }

    public function install(ZentlixBundleInterface $bundleClass, Bundle $bundleEntity): void
    {
        $this->copyRoutes(get_class($bundleClass));
        $this->copyPublicFiles(get_class($bundleClass));
        $this->copyTemplates(get_class($bundleClass));

        foreach ($bundleClass->installMailerEvents() as $mailerEvent) {
            $mailerEvent->setBundle($bundleEntity);
            $this->entityManager->persist($mailerEvent);
        }
    }

    public function replaceSecurityConfig(): void
    {
        $this->filesystem->remove($this->kernel->getProjectDir() . '/config/packages/security.yaml');
        $this->filesystem->copy(
            $this->kernel->locateResource('@UserBundle/Resources/global/packages/security.yaml'),
            $this->kernel->getProjectDir() . '/config/packages/security.yaml'
        );
    }

    public function copyHtaccess(): void
    {
        $this->filesystem->copy(
            $this->kernel->locateResource('@MainBundle/Resources/global/.htaccess'),
            $this->kernel->getProjectDir() . '/public/.htaccess'
        );
    }

    private function copyRoutes($class): void
    {
        $routesDir = $this->getBundleResourceDir($class) . 'global/routes';

        $finder = new Finder();
        if(is_dir($routesDir)) {
            $routes = $finder->files()->in($routesDir);
            if($routes->hasResults()) {
                foreach ($finder as $file) {
                    $this->filesystem->copy($file->getRealPath(), $this->kernel->getProjectDir() . '/config/routes/' . $file->getFilename());
                }
            }
        }
    }

    private function copyPublicFiles($class): void
    {
        $publicDir = $this->getBundleResourceDir($class) . 'global/public';

        if(is_dir($publicDir)) {
            $this->filesystem->mirror($publicDir, $this->kernel->getProjectDir() . '/public/zentlix/');
        }
    }

    private function copyTemplates($class): void
    {
        $templatesDir = $this->getBundleResourceDir($class) . 'global/templates';

        if(is_dir($templatesDir)) {
            $this->filesystem->mirror($templatesDir, $this->kernel->getProjectDir() . '/templates/');
        }
    }

    private function getBundleResourceDir(string $class): string
    {
        $reflector = new \ReflectionClass($class);

        return $this->kernel->locateResource(sprintf('@%s/Resources/', $reflector->getShortName()));
    }
}