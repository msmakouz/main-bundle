<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Specification;

use Doctrine\ORM\NonUniqueResultException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Attribute\Repository\AttributeRepository;
use function is_null;

final class UniqueCodeSpecification
{
    private AttributeRepository $repository;
    private TranslatorInterface $translator;

    public function __construct(AttributeRepository $repository, TranslatorInterface $translator)
    {
        $this->repository = $repository;
        $this->translator = $translator;
    }

    public function isUnique(string $code, string $entity): void
    {
        if(is_null($this->repository->findOneBy(['code' => $code, 'entity' => $entity])) === false) {
            throw new NonUniqueResultException(sprintf($this->translator->trans('zentlix_main.attribute.already_exist'), $code));
        }
    }

    public function __invoke(string $code, string $entity): void
    {
        $this->isUnique($code, $entity);
    }
}