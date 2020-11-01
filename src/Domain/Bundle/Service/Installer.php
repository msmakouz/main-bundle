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

    public function install(ZentlixBundleInterface $bundleClass): void
    {
        $this->installRoutes(get_class($bundleClass));
        $this->installPublicFiles(get_class($bundleClass));
        $this->installTemplates(get_class($bundleClass));
    }

    public function remove(ZentlixBundleInterface $bundleClass): void
    {
        $this->removeRoutes(get_class($bundleClass));
        $this->removePublicFiles(get_class($bundleClass));
        $this->removeTemplates(get_class($bundleClass));
    }

    private function installRoutes($class): void
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

    private function removeRoutes($class): void
    {
        $routesDir = $this->getBundleResourceDir($class) . 'global/routes';

        $finder = new Finder();
        if(is_dir($routesDir)) {
            $routes = $finder->files()->in($routesDir);
            if($routes->hasResults()) {
                foreach ($finder as $file) {
                    if(is_file($this->kernel->getProjectDir() . '/config/routes/' . $file->getFilename())) {
                        $this->filesystem->remove($this->kernel->getProjectDir() . '/config/routes/' . $file->getFilename());
                    }
                }
            }
        }
    }

    private function installPublicFiles($class): void
    {
        $publicDir = $this->getBundleResourceDir($class) . 'global/public';

        if(is_dir($publicDir)) {
            $this->filesystem->mirror($publicDir, $this->kernel->getProjectDir() . '/public/zentlix/');
        }
    }

    private function removePublicFiles($class): void
    {
        $publicDir = $this->getBundleResourceDir($class) . 'global/public';

        if(is_dir($publicDir)) {
            $finder = new Finder();
            $public = $finder->in($publicDir);
            if($public->hasResults()) {
                foreach ($public as $element) {
                    $this->filesystem->remove($this->kernel->getProjectDir() . '/public/zentlix/' . $element->getFilename());
                }
            }
        }
    }

    private function installTemplates($class): void
    {
        $templatesDir = $this->getBundleResourceDir($class) . 'global/templates';

        if(is_dir($templatesDir)) {
            $this->filesystem->mirror($templatesDir, $this->kernel->getProjectDir() . '/templates/');
        }
    }

    private function removeTemplates($class): void
    {
        $templatesDir = $this->getBundleResourceDir($class) . 'global/templates';

        if(is_dir($templatesDir)) {
            $finder = new Finder();
            $templates = $finder->in($templatesDir);
            if($templates->hasResults()) {
                foreach ($templates as $element) {
                    $this->filesystem->remove($this->kernel->getProjectDir() . '/templates/' . $element->getFilename());
                }
            }
        }
    }

    private function getBundleResourceDir(string $class): string
    {
        $reflector = new \ReflectionClass($class);

        return $this->kernel->locateResource(sprintf('@%s/Resources/', $reflector->getShortName()));
    }
}