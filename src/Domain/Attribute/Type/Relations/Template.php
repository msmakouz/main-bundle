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

use Zentlix\MainBundle\Domain\Template\Read\CollectionFilter;
use Zentlix\MainBundle\Domain\Template\Read\TemplateFetcher;
use Zentlix\MainBundle\Infrastructure\Collection\Collection;

final class Template implements RelationInterface
{
    private TemplateFetcher $repository;

    public function __construct(TemplateFetcher $repository)
    {
        $this->repository = $repository;
    }

    public static function getTitle(): string
    {
        return 'zentlix_main.template.site_template';
    }

    public static function getCode(): string
    {
        return 'template';
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