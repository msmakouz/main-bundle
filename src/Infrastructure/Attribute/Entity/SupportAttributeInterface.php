<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Attribute\Entity;

interface SupportAttributeInterface
{
    public function getId();

    public static function getEntityCode(): string;

    public static function getEntityTitle(): string;
}
