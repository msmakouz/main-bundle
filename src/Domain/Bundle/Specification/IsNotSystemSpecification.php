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

use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;

final class IsNotSystemSpecification
{
    private BundleRepository $bundleRepository;

    public function __construct(BundleRepository $bundleRepository)
    {
        $this->bundleRepository = $bundleRepository;
    }

    public function isNotSystem(int $id): bool
    {
        return !$this->bundleRepository->get($id)->isSystem();
    }

    public function __invoke(int $id): bool
    {
        return $this->isNotSystem($id);
    }
}
