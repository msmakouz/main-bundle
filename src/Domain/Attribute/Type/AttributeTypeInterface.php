<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

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
    public function buildField(FormBuilderInterface $builder, array $options, Attribute $attribute, SupportAttributeInterface $entity): void;
    public function normalizeSavedValue($value);
    public function normalizeValue($value, Attribute $attribute);
}