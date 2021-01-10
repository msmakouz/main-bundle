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

use Zentlix\MainBundle\Domain\Locale\Read\CollectionFilter;
use Zentlix\MainBundle\Domain\Locale\Read\LocaleFetcher;
use Zentlix\MainBundle\Infrastructure\Collection\Collection;

final class Locale implements RelationInterface
{
    private LocaleFetcher $repository;

    public function __construct(LocaleFetcher $repository)
    {
        $this->repository = $repository;
    }

    public static function getTitle(): string
    {
        return 'zentlix_main.locale.locale';
    }

    public static function getCode(): string
    {
        return 'locale';
    }

    public function getRelations(): array
    {
        return [
            static::getCode() => static::getTitle()
        ];
    }

    public function getElements(array $elementIds): Collection
    {
        return $this->repository->findByFilter(new CollectionFilter(['id' => $elementIds]));
    }

    public function getElementsAssoc(): array
    {
        return $this->repository->assoc();
    }
}