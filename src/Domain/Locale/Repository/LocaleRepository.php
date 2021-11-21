<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Locale\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Domain\Shared\Repository\CodeTrait;
use Zentlix\MainBundle\Domain\Shared\Repository\GetTrait;

/**
 * @method Locale      get($id, $lockMode = null, $lockVersion = null)
 * @method Locale      getOneByCode(string $code)
 * @method Locale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Locale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Locale|null findOneByCode(string $code)
 * @method Locale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocaleRepository extends ServiceEntityRepository
{
    use GetTrait;
    use CodeTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Locale::class);
    }

    public function findAll()
    {
        return $this->findBy([], ['sort' => 'ASC', 'title' => 'asc']);
    }

    public function assoc(): array
    {
        $locales = $this->createQueryBuilder('a')
            ->select('a.id', 'a.title')
            ->orderBy('a.sort')
            ->getQuery()
            ->execute();

        $result = [];
        foreach ($locales as $locale) {
            $result[$locale['id']->toRfc4122()] = $locale['title'];
        }

        return $result;
    }
}
