<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Specification;

use Doctrine\ORM\NonUniqueResultException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Shared\Specification\AbstractSpecification;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;

final class UniqueClassSpecification extends AbstractSpecification
{
    private BundleRepository $bundleRepository;
    private TranslatorInterface $translator;

    public function __construct(BundleRepository $bundleRepository, TranslatorInterface $translator)
    {
        $this->bundleRepository = $bundleRepository;
        $this->translator = $translator;
    }

    public function isUnique(string $class): bool
    {
        return $this->isSatisfiedBy($class);
    }

    public function isSatisfiedBy($value): bool
    {
        if($this->bundleRepository->findOneBy(['class' => $value]) !== null) {
            throw new NonUniqueResultException($this->translator->trans('zentlix_main.bundle.already_exist'));
        }

        return true;
    }

    public function __invoke(string $class)
    {
        return $this->isUnique($class);
    }
}
