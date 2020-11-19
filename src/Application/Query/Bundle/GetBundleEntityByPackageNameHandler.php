<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Bundle;

use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;
use function get_class;

class GetBundleEntityByPackageNameHandler implements QueryHandlerInterface
{
    private Bundles $bundles;
    private BundleRepository $bundleRepository;

    public function __construct(Bundles $bundles, BundleRepository $bundleRepository)
    {
        $this->bundles = $bundles;
        $this->bundleRepository = $bundleRepository;
    }

    public function __invoke(GetBundleEntityByPackageNameQuery $query): Bundle
    {
        return $this->bundleRepository->getOneByClass(get_class($this->bundles->getByPackageName($query->package)));
    }
}