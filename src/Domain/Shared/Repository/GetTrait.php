<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Repository;

use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

trait GetTrait
{
    public function get($id, $lockMode = null, $lockVersion = null)
    {
        $object = $this->find($id, $lockMode, $lockVersion);

        if(!$object) {
            throw new NotFoundException('Entity not found.');
        }

        return $object;
    }

    public function getOneBy(array $criteria, array $orderBy = null)
    {
        $object = $this->findOneBy($criteria, $orderBy);

        if(!$object) {
            throw new NotFoundException('Entity not found.');
        }

        return $object;
    }
}