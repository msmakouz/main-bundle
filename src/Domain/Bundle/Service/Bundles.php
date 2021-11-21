<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Service;

use Composer\Json\JsonFile;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;
use Zentlix\MainBundle\ZentlixBundleInterface;

class Bundles
{
    /** @var ZentlixBundleInterface[] */
    private array $bundles = [];
    private BundleRepository $bundleRepository;

    public function __construct(iterable $bundles, BundleRepository $bundleRepository)
    {
        $this->bundleRepository = $bundleRepository;

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
        $bundle = $this->findByPackageName($package);

        if (\is_null($bundle)) {
            throw new \Exception(sprintf('Bundle %s not found or not implement ZentlixBundleInterface.', $package));
        }

        return $bundle;
    }

    public function findByPackageName(string $package): ?ZentlixBundleInterface
    {
        foreach ($this->bundles as $bundle) {
            if ($bundle->getBundleName() === $package) {
                return $bundle;
            }
        }

        return null;
    }

    public function getByClass(string $class): ZentlixBundleInterface
    {
        if (isset($this->bundles[$class])) {
            return $this->bundles[$class];
        }

        throw new \Exception('Bundle class not found or not implement ZentlixBundleInterface');
    }

    public function getBundleByNamespace(string $namespace): ZentlixBundleInterface
    {
        return $this->getByClass(
            'Zentlix\\' . self::getBundleNameFromNamespace($namespace) . '\\' .
            self::getBundleNameFromNamespace($namespace)
        );
    }

    public function isBundle(string $class): bool
    {
        $bundleName = self::findBundleNameFromNamespace($class);
        if (\is_null($bundleName)) {
            return false;
        }

        return isset($this->bundles['Zentlix\\' . $bundleName . '\\' . $bundleName]);
    }

    public static function getBundleNameFromNamespace(string $namespace): string
    {
        $pieces = explode('\\', $namespace);

        return $pieces[1];
    }

    public static function findBundleNameFromNamespace(string $namespace): ?string
    {
        $pieces = explode('\\', $namespace);

        return is_array($pieces) && isset($pieces[1]) ? $pieces[1] : null;
    }

    public function isInstalled(string $package): bool
    {
        foreach ($this->bundles as $bundle) {
            if ($bundle->getBundleName() === $package) {
                return true;
            }
        }

        return false;
    }

    public static function isZentlixBundle($package): bool
    {
        $composerJson = sprintf('%s/%s/composer.json', \dirname(__DIR__, 6), $package);

        if (!file_exists($composerJson)) {
            return false;
        }
        $composerJson = (new JsonFile($composerJson))->read();

        if (!isset($composerJson['autoload']['psr-4'])) {
            return false;
        }

        $namespace = array_diff(explode('\\', array_key_first($composerJson['autoload']['psr-4'])), ['']);
        $class = array_key_first($composerJson['autoload']['psr-4']) . end($namespace);

        if (!class_exists($class)) {
            return false;
        }

        $reflection = new \ReflectionClass($class);

        return $reflection->implementsInterface(ZentlixBundleInterface::class);
    }

    private function addBundle(ZentlixBundleInterface $bundle): void
    {
        $this->bundles[$bundle::class] = $bundle;
    }
}
