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

use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Application\Query\NotFoundException;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;
use Zentlix\MainBundle\Domain\Shared\Specification\AbstractSpecification;

final class ExistBundleSpecification extends AbstractSpecification
{
    private BundleRepository $bundleRepository;
    private TranslatorInterface $translator;

    public function __construct(BundleRepository $bundleRepository, TranslatorInterface $translator)
    {
        $this->bundleRepository = $bundleRepository;
        $this->translator = $translator;
    }

    public function isExist(int $bundleId): bool
    {
        return $this->isSatisfiedBy($bundleId);
    }

    public function isSatisfiedBy($value): bool
    {
        $bundle = $this->bundleRepository->find($value);

        if(is_null($bundle)) {
            throw new NotFoundException(\sprintf($this->translator->trans('zentlix_main.bundle.not_exist'), $value));
        }

        return true;
    }

    public function __invoke(int $bundleId)
    {
        return $this->isExist($bundleId);
    }
}