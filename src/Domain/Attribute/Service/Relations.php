<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

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
        if(!isset($this->relations[$code])) {
            throw new \DomainException(sprintf('Relation %s not found!', $code));
        }

        return $this->relations[$code];
    }

    private function addRelation(RelationInterface $relation): void
    {
        if(isset($this->relations[$relation::getCode()])) {
            throw new \DomainException(sprintf('Relation %s already exist!', $relation::getCode()));
        }

        $this->relations[$relation::getCode()] = $relation;
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
}