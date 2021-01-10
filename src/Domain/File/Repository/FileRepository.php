<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\File\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Zentlix\MainBundle\Domain\File\Entity\File;
use Zentlix\MainBundle\Domain\Shared\Repository\GetTrait;
use function is_null;

/**
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File      get($id, $lockMode = null, $lockVersion = null)
 * @method File      getOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileRepository extends ServiceEntityRepository
{
    use GetTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

    public function findDeleted(): array
    {
        return $this->findBy(['deleted' => 1]);
    }

    public function findOneByPath(string $path): ?File
    {
        return $this->findOneBy(['path' => $path]);
    }

    public function getOneByPath(string $path): File
    {
        $file = $this->findOneBy(['path' => $path]);

        if(is_null($file)) {
            throw new \DomainException(sprintf('File %s not found.', $path));
        }

        return $file;
    }
}