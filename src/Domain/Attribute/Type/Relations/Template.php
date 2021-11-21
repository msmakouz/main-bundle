<?php

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
            static::getCode() => static::getTitle(),
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
