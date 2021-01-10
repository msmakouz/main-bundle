<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Attribute;

use Zentlix\MainBundle\Domain\Attribute\Service\Attributes;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;

class GetEntitiesHandler implements QueryHandlerInterface
{
    private Attributes $attributes;

    public function __construct(Attributes $attributes)
    {
        $this->attributes = $attributes;
    }

    public function __invoke(GetEntitiesQuery $query): array
    {
        return $this->attributes->getSupportEntities();
    }
}