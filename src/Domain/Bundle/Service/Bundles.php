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

use Zentlix\MainBundle\ZentlixBundleInterface;

class Bundles
{
    /** @var ZentlixBundleInterface[] */
    private array $bundles = [];

    public function __construct(iterable $bundles)
    {
        foreach ($bundles as $bundle) {
            $this->addBundle($bundle);
        }
    }

    public function getBundles(): array
    {
        return $this->bundles;
    }

    public function getByPackageName(string $package): ZentlixBundleInterface
    {
        foreach ($this->bundles as $bundle) {
            if($bundle->getBundleName() === $package) {
                return $bundle;
            }
        }

        throw new \Exception(sprintf('Bundle %s not found or not implement ZentlixBundleInterface.', $package));
    }

    public function getByClass(string $class): ZentlixBundleInterface
    {
       if(isset($this->bundles[$class])) {
           return $this->bundles[$class];
       }

       throw new \Exception('Bundle class not found or not implement ZentlixBundleInterface');
    }

    public function getBundleByNamespace(string $namespace): ZentlixBundleInterface
    {
        return $this->getByClass('Zentlix\\' . self::getBundleNameFromNamespace($namespace) . '\\' . self::getBundleNameFromNamespace($namespace));
    }

    public function isBundle(string $class): bool
    {
        return isset($this->bundles[$class]);
    }

    public static function getBundleNameFromNamespace(string $namespace): string
    {
        $pieces = explode('\\', $namespace);

        return $pieces[1];
    }

    private function addBundle(ZentlixBundleInterface $bundle): void
    {
        $this->bundles[get_class($bundle)] = $bundle;
    }
}