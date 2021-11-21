<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Bundle;

use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;

class GetBundleEntityByPackageNameHandler implements QueryHandlerInterface
{
    public function __construct(
        private Bundles $bundles,
        private BundleRepository $bundleRepository
    ) {
    }

    public function __invoke(GetBundleEntityByPackageNameQuery $query): Bundle
    {
        return $this->bundleRepository->getOneByClass($this->bundles->getByPackageName($query->package)::class);
    }
}
