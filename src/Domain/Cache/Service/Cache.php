<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Cache\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\Filesystem\Filesystem;

class Cache
{
    public const SITES = 'zentlix.sites';
    private ?string $cacheDir = null;

    public function __construct(ContainerInterface $container)
    {
        $this->cacheDir = $container->getParameter('kernel.cache_dir');
    }

    /**
     * @param string $tag
     * @return mixed|null
     * @throws \Psr\Cache\CacheException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public static function get(string $tag)
    {
        $cache = new TagAwareAdapter(new FilesystemAdapter());

        $tagCache = $cache->getItem($tag);
        $tagCache->tag($tag);

        if(!$tagCache->isHit()) {
            return null;
        }

        return $tagCache->get();
    }

    /**
     * @param $data
     * @param string $tag
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public static function set($data, string $tag): void
    {
        $cache = new TagAwareAdapter(new FilesystemAdapter());
        $tagCache = $cache->getItem($tag);

        $tagCache->set($data);
        $cache->save($tagCache);
    }

    /**
     * @param string $tag
     */
    public static function clear(string $tag): void
    {
        $cache = new FilesystemAdapter();
        $cache->delete($tag);
    }

    public function clearRoutes(): void
    {
        $fs = new Filesystem();
        if($fs->exists($this->cacheDir . DIRECTORY_SEPARATOR . 'UrlGenerator.php')) {
            $fs->remove($this->cacheDir . DIRECTORY_SEPARATOR . 'UrlGenerator.php');
        }
        if($fs->exists($this->cacheDir . DIRECTORY_SEPARATOR . 'UrlGenerator.php.meta')) {
            $fs->remove($this->cacheDir . DIRECTORY_SEPARATOR . 'UrlGenerator.php.meta');
        }
        if($fs->exists($this->cacheDir . DIRECTORY_SEPARATOR . 'UrlMatcher.php')) {
            $fs->remove($this->cacheDir . DIRECTORY_SEPARATOR . 'UrlMatcher.php');
        }
        if($fs->exists($this->cacheDir . DIRECTORY_SEPARATOR . 'UrlMatcher.php.meta')) {
            $fs->remove($this->cacheDir . DIRECTORY_SEPARATOR . 'UrlMatcher.php.meta');
        }
    }
}