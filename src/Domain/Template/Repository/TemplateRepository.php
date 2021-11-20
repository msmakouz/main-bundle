<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Template\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Zentlix\MainBundle\Domain\Shared\Repository\GetTrait;
use Zentlix\MainBundle\Domain\Template\Entity\Template;

/**
 * @method Template|null find($id, $lockMode = null, $lockVersion = null)
 * @method Template|null findOneBy(array $criteria, array $orderBy = null)
 * @method Template      get($id, $lockMode = null, $lockVersion = null)
 * @method Template[]    findAll()
 * @method Template[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemplateRepository extends ServiceEntityRepository
{
    use GetTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Template::class);
    }

    public function assoc(): array
    {
        $templates = $this->createQueryBuilder('a')
            ->select('a.id', 'a.title')
            ->orderBy('a.sort')
            ->getQuery()
            ->execute();

        $result = [];
        foreach ($templates as $template) {
            $result[$template['id']->toRfc4122()] = $template['title'];
        }

        return $result;
    }
}