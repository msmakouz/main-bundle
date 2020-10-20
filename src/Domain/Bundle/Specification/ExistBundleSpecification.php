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
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;
use function is_null;

final class ExistBundleSpecification
{
    private BundleRepository $bundleRepository;
    private TranslatorInterface $translator;

    public function __construct(BundleRepository $bundleRepository, TranslatorInterface $translator)
    {
        $this->bundleRepository = $bundleRepository;
        $this->translator = $translator;
    }

    public function isExist(int $bundleId): void
    {
        if(is_null($this->bundleRepository->find($bundleId))) {
            throw new NotFoundException(sprintf($this->translator->trans('zentlix_main.bundle.not_exist'), $bundleId));
        }
    }

    public function __invoke(int $bundleId): void
    {
        $this->isExist($bundleId);
    }
}