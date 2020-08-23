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

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;

class Cache
{
    public const SITES = 'zentlix.sites';
    protected ?string $cacheDir = null;

    public function __construct(string $cacheDir)
    {
        $this->cacheDir = $cacheDir;
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
}