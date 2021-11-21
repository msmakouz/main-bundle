<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Attribute\Type;

abstract class AbstractFileType
{
    public static function getTitle(): string
    {
        return 'zentlix_main.attribute.file';
    }

    public static function getCode(): string
    {
        return 'file';
    }

    abstract public function getCreateForm(array $options = []): string;

    abstract public function getUpdateForm($attribute, array $options = []): string;
}
