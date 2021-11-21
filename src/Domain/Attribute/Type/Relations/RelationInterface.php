<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Type\Relations;

use Zentlix\MainBundle\Infrastructure\Collection\Collection;

interface RelationInterface
{
    public static function getTitle(): string;

    public static function getCode(): string;

    public function getRelations(): array;

    public function getElementsAssoc(): array;

    public function getElements(array $elementIds): Collection;
}
