<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Entity;

use Doctrine\ORM\Mapping;

trait SortTrait
{
    /** @Mapping\Column(type="integer", options={"default": "1"}) */
    private int $sort = 1;

    public function getSort(): int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }
}
