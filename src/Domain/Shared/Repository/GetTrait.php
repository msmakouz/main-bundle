<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Repository;

use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

trait GetTrait
{
    public function get($id, $lockMode = null, $lockVersion = null)
    {
        $object = $this->find($id, $lockMode, $lockVersion);

        if (!$object) {
            throw new NotFoundException('Entity not found.');
        }

        return $object;
    }

    public function getOneBy(array $criteria, array $orderBy = null)
    {
        $object = $this->findOneBy($criteria, $orderBy);

        if (!$object) {
            throw new NotFoundException('Entity not found.');
        }

        return $object;
    }
}
