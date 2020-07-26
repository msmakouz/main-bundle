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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Zentlix\MainBundle\AbstractZentlixBundle;
use Zentlix\MainBundle\ZentlixBundleInterface;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;

class Bundles
{

    private ContainerInterface $container;
    private string $projectDir;

    public function __construct(ContainerInterface $container, string $projectDir)
    {
        $this->container = $container;
        $this->projectDir = $projectDir;
    }

    public function getByClass(string $class): ZentlixBundleInterface
    {
       if(class_exists($class)) {
           $bundle = new $class();
           if($bundle instanceof ZentlixBundleInterface) {
               return $bundle;
           }
       }

       throw new \Exception('Bundle class not found or not implement ZentlixBundleInterface');
    }

    public function getBundleByNamespace(string $namespace): ZentlixBundleInterface
    {
        return $this->getByClass('Zentlix\\' . self::getBundleNameFromNamespace($namespace) . '\\' . self::getBundleNameFromNamespace($namespace));
    }

    public function isBundle(string $class): bool
    {
        $implements = class_implements($class);

        return in_array(ZentlixBundleInterface::class, $implements);
    }

    public function installBundlesRouting(Site $site): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        /** @var BundleRepository $bundleRepository */
        $bundleRepository = $entityManager->getRepository(Bundle::class);
        $bundles = $bundleRepository->findAll();

        /** @var Bundle $bundle */
        foreach ($bundles as $bundle) {
            /** @var AbstractZentlixBundle $kernel */
            $kernel = $this->getByClass($bundle->getClass());
            $kernel->installFrontendRoutesForSite($site);
        }
    }

    public static function getBundleNameFromNamespace(string $namespace): string
    {
        $pieces = explode('\\', $namespace);

        return $pieces[1];
    }
}