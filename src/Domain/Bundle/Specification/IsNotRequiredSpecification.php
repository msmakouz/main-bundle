<?php

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

    public function __invoke(string $package): void
    {
        $this->isNotRequired($package);
    }

    public function isNotRequired(string $package): void
    {
        foreach ($this->bundles->getBundles() as $bundle) {
            if ($bundle->isPackageRequired($package)) {
                $bundleName = $this->translator->trans($bundle->getTitle());
                throw new \DomainException(
                    sprintf($this->translator->trans('zentlix_main.bundle.remove.required'), $bundleName)
                );
            }
        }
    }
}
