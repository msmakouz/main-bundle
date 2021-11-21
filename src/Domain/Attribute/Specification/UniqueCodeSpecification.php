<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Specification;

use Doctrine\ORM\NonUniqueResultException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Attribute\Repository\AttributeRepository;

final class UniqueCodeSpecification
{
    private AttributeRepository $repository;
    private TranslatorInterface $translator;

    public function __construct(AttributeRepository $repository, TranslatorInterface $translator)
    {
        $this->repository = $repository;
        $this->translator = $translator;
    }

    public function __invoke(string $code, string $entity): void
    {
        $this->isUnique($code, $entity);
    }

    public function isUnique(string $code, string $entity): void
    {
        if (false === is_null($this->repository->findOneBy(['code' => $code, 'entity' => $entity]))) {
            throw new NonUniqueResultException(
                sprintf($this->translator->trans('zentlix_main.attribute.already_exist'), $code)
            );
        }
    }
}
