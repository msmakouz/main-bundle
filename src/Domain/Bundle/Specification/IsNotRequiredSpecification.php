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
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;

final class IsNotRequiredSpecification
{
    private Bundles $bundles;
    private TranslatorInterface $translator;

    public function __construct(Bundles $bundles, TranslatorInterface $translator)
    {
        $this->bundles = $bundles;
        $this->translator = $translator;
    }

    public function isNotRequired(string $package): void
    {
        foreach ($this->bundles->getBundles() as $bundle) {
            if($bundle->isPackageRequired($package)) {
                $bundleName = $this->translator->trans($bundle->getTitle());
                throw new \DomainException(sprintf($this->translator->trans('zentlix_main.bundle.remove.required'), $bundleName));
            }
        }
    }

    public function __invoke(string $package): void
    {
        $this->isNotRequired($package);
    }
}