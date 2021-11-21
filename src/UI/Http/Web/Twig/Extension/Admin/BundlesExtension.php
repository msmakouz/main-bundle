<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Twig\Extension\Admin;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles as BundlesService;

final class BundlesExtension extends AbstractExtension
{
    private BundlesService $bundles;

    public function __construct(BundlesService $bundles)
    {
        $this->bundles = $bundles;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'is_bundle_installed',
                fn (string $package) => $this->bundles->isInstalled($package),
                ['is_safe' => ['html']]
            ),
        ];
    }
}
