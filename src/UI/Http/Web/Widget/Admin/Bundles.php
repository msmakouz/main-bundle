<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Widget\Admin;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles as BundlesService;

class Bundles extends AbstractExtension
{
    private BundlesService $bundles;

    public function __construct(BundlesService $bundles)
    {
        $this->bundles = $bundles;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_bundle_installed', fn (string $package) => $this->bundles->isInstalled($package), ['is_safe' => ['html']])
        ];
    }
}