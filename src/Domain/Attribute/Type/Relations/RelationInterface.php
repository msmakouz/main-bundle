<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

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