<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Service;

use Zentlix\MainBundle\Domain\Attribute\Type\Relations\RelationInterface;

class Relations
{
    /** @var RelationInterface[] */
    private array $relations = [];

    public function __construct(iterable $relations)
    {
        foreach ($relations as $relation) {
            $this->addRelation($relation);
        }
    }

    public function getRelations(): array
    {
        return $this->relations;
    }

    public function getByCode(string $code): RelationInterface
    {
        if (!isset($this->relations[$code])) {
            throw new \DomainException(sprintf('Relation %s not found!', $code));
        }

        return $this->relations[$code];
    }

    public function assoc(): array
    {
        $result = [];
        foreach ($this->relations as $relation) {
            foreach ($relation->getRelations() as $code => $title) {
                $result[$title] = $code;
            }
        }

        return $result;
    }

    private function addRelation(RelationInterface $relation): void
    {
        if (isset($this->relations[$relation::getCode()])) {
            throw new \DomainException(sprintf('Relation %s already exist!', $relation::getCode()));
        }

        $this->relations[$relation::getCode()] = $relation;
    }
}
