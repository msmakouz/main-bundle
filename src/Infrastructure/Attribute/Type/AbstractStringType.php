<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Attribute\Type;

abstract class AbstractStringType
{
    public static function getTitle(): string
    {
        return 'zentlix_main.attribute.string';
    }

    public static function getCode(): string
    {
        return 'string';
    }

    abstract public function getCreateForm(array $options = []): string;

    abstract public function getUpdateForm($attribute, array $options = []): string;
}
