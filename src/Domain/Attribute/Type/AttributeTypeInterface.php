<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;
use Zentlix\MainBundle\Infrastructure\Attribute\Entity\SupportAttributeInterface;

interface AttributeTypeInterface
{
    public static function getCode(): string;

    public static function getTitle(): string;

    public function getCreateForm(array $options = []): string;

    public function getUpdateForm($attribute, array $options = []): string;

    public function buildField(
        FormBuilderInterface $builder,
        array $options,
        Attribute $attribute,
        SupportAttributeInterface $entity
    ): void;

    public function normalizeSavedValue($value);

    public function normalizeValue($value, Attribute $attribute);
}
