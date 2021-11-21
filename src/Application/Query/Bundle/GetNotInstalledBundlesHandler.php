<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Bundle;

use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;

class GetNotInstalledBundlesHandler implements QueryHandlerInterface
{
    public function __construct(
        private Bundles $bundles,
        private BundleRepository $bundleRepository
    ) {
    }

    public function __invoke(GetNotInstalledBundlesQuery $query): array
    {
        $classes = array_map(fn (Bundle $bundle) => $bundle->getClass(), $this->bundleRepository->findAll());

        $result = [$this->bundles->getByPackageName($query->package)];
        foreach ($result[0]->getRequire() as $package => $version) {
            $bundle = $this->bundles->findByPackageName($package);
            if (!\is_null($bundle) && !\in_array($bundle::class, $classes, true)) {
                $result[] = $bundle;
            }
        }

        return $result;
    }
}
