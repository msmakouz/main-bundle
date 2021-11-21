<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;
use Zentlix\MainBundle\Domain\Attribute\Entity\Value;
use Zentlix\MainBundle\Domain\Cache\Service\Cache;
use Zentlix\MainBundle\Infrastructure\Attribute\Entity\SupportAttributeInterface;

class Attributes
{
    private EntityManagerInterface $entityManager;
    private AttributeTypes $attributeTypes;

    public function __construct(EntityManagerInterface $entityManager, AttributeTypes $attributeTypes)
    {
        $this->entityManager = $entityManager;
        $this->attributeTypes = $attributeTypes;
    }

    public function getSupportEntities(): array
    {
        $classes = [];
        $metas = $this->entityManager->getMetadataFactory()->getAllMetadata();
        foreach ($metas as $meta) {
            if (\in_array(SupportAttributeInterface::class, class_implements($meta->getName()), true)) {
                $classes[] = $meta->getName();
            }
        }

        return $classes;
    }

    public function saveValues(SupportAttributeInterface $entity, array $attributeValues): void
    {
        $attributes = $this->entityManager
            ->getRepository(Attribute::class)
            ->findActiveByEntity($entity::getEntityCode());

        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {
            if (isset($attributeValues[$attribute->getCode()])) {
                $oldValues = $this->entityManager
                    ->getRepository(Value::class)
                    ->findByAttributeAndEntity($attribute->getId(), $entity->getId());
                foreach ($oldValues as $value) {
                    $this->entityManager->remove($value);
                }

                foreach ((array) $attributeValues[$attribute->getCode()] as $val) {
                    $val = $this->attributeTypes->getByCode($attribute->getAttributeType())->normalizeSavedValue($val);
                    $this->entityManager->persist(new Value(Uuid::v4(), $val, $entity->getId(), $attribute));
                }
            }
        }

        $this->entityManager->flush();
    }

    public function removeValues($entityId): void
    {
        $values = $this->entityManager->getRepository(Value::class)->findByEntityId($entityId);
        foreach ($values as $value) {
            $this->entityManager->remove($value);
        }

        $this->entityManager->flush();
    }

    public function getAttributeValue(string $attributeCode, $entityId, $default = null)
    {
        $attribute = $this->findCachedAttributeByCode($attributeCode);

        if (\is_null($attribute)) {
            return $default;
        }

        $values = $this->entityManager
            ->getRepository(Value::class)
            ->findByAttributeAndEntity($attribute->getId(), $entityId);

        if (0 === \count($values)) {
            return $default;
        }

        $config = $attribute->getConfig();
        if (!isset($config['multiple']) || !$config['multiple']) {
            $values = array_shift($values);
        }

        $normalizedValue = $this->attributeTypes
            ->getByCode($attribute->getAttributeType())
            ->normalizeValue($values, $attribute);

        return $normalizedValue;
    }

    public function getTemplateAttribute(string $templateId, string $code)
    {
        $attribute = $this->findCachedAttributeByCode($code);

        if (\is_null($attribute)) {
            return null;
        }

        return $this->findCachedTemplateValue($attribute, $templateId);
    }

    private function findCachedAttributeByCode(string $code): ?Attribute
    {
        $attribute = Cache::findAttribute($code);

        if (!\is_null($attribute)) {
            return $attribute;
        }

        $attribute = $this->entityManager->getRepository(Attribute::class)->findOneByCode($code);

        if ($attribute) {
            Cache::setAttribute($attribute);
        }

        return $attribute;
    }

    private function findCachedTemplateValue(Attribute $attribute, string $templateId)
    {
        $cached = Cache::findTemplateAttributeValues($attribute->getCode());

        if (!\is_null($cached) && isset($cached[$attribute->getCode()])) {
            return $cached[$attribute->getCode()];
        }

        $values = $this->entityManager
            ->getRepository(Value::class)
            ->findByAttributeAndEntity($attribute->getId(), $templateId);

        if (0 === \count($values)) {
            return null;
        }

        $config = $attribute->getConfig();
        if (!isset($config['multiple']) || !$config['multiple']) {
            $values = array_shift($values);
        }

        $normalizedValue = $this->attributeTypes
            ->getByCode($attribute->getAttributeType())
            ->normalizeValue($values, $attribute);

        Cache::setTemplateAttributeValues($attribute->getCode(), $normalizedValue);

        return $normalizedValue;
    }
}
