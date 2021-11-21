<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Attribute;

use Zentlix\MainBundle\Domain\Attribute\Service\Attributes;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;

class GetEntitiesHandler implements QueryHandlerInterface
{
    public function __construct(
        private Attributes $attributes
    ) {
    }

    public function __invoke(GetEntitiesQuery $query): array
    {
        return $this->attributes->getSupportEntities();
    }
}
