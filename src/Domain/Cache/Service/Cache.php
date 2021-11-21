<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Cache\Service;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;

class Cache
{
    public const SITES = 'zentlix_main.sites';
    public const ATTRIBUTES = 'zentlix_main.attributes';
    public const TEMPLATE_ATTRIBUTE_VALUES = 'zentlix_main.template_attr_values';
    protected ?string $cacheDir = null;

    public function __construct(string $cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * @return mixed|null
     * @throws \Psr\Cache\CacheException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public static function get(string $tag)
    {
        $cache = new TagAwareAdapter(new FilesystemAdapter());

        $tagCache = $cache->getItem($tag);
        $tagCache->tag($tag);

        if (!$tagCache->isHit()) {
            return null;
        }

        return $tagCache->get();
    }

    /**
     * @param $data
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public static function set($data, string $tag): void
    {
        $cache = new TagAwareAdapter(new FilesystemAdapter());
        $tagCache = $cache->getItem($tag);

        $tagCache->set($data);
        $cache->save($tagCache);
    }

    public static function clear(string $tag): void
    {
        $cache = new FilesystemAdapter();
        $cache->delete($tag);
    }

    public static function findTemplateAttributeValues(string $attributeCode)
    {
        $values = self::get(self::TEMPLATE_ATTRIBUTE_VALUES);

        if (!\is_null($values) && isset($values[$attributeCode])) {
            return $values[$attributeCode];
        }

        return null;
    }

    public static function setTemplateAttributeValues(string $attributeCode, $values): void
    {
        $cached = self::get(self::TEMPLATE_ATTRIBUTE_VALUES);

        if (!\is_array($cached)) {
            $cached = [];
        }
        $cached[$attributeCode] = $values;

        self::set($cached, self::TEMPLATE_ATTRIBUTE_VALUES);
    }

    public static function findAttribute(string $code): ?Attribute
    {
        $attributes = self::get(self::ATTRIBUTES);

        if (!\is_null($attributes) && isset($attributes[$code])) {
            return $attributes[$code];
        }

        return null;
    }

    public static function setAttribute(Attribute $attribute): void
    {
        $attributes = self::get(self::ATTRIBUTES);

        if (!\is_array($attributes)) {
            $attributes = [];
        }

        $attributes[$attribute->getCode()] = $attribute;

        self::set($attributes, self::ATTRIBUTES);
    }
}
