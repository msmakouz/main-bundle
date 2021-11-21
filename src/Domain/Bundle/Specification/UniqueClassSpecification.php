<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Specification;

use Doctrine\ORM\NonUniqueResultException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;

final class UniqueClassSpecification
{
    private BundleRepository $bundleRepository;
    private TranslatorInterface $translator;

    public function __construct(BundleRepository $bundleRepository, TranslatorInterface $translator)
    {
        $this->bundleRepository = $bundleRepository;
        $this->translator = $translator;
    }

    public function __invoke(string $class): void
    {
        $this->isUnique($class);
    }

    public function isUnique(string $class): void
    {
        if (false === \is_null($this->bundleRepository->findOneByClass($class))) {
            throw new NonUniqueResultException($this->translator->trans('zentlix_main.bundle.already_exist'));
        }
    }
}
