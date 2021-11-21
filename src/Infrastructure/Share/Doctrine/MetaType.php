<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Share\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

class MetaType extends JsonType
{
    public const NAME = 'meta';

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
