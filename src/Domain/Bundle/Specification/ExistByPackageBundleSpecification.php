<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Specification;

use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

final class ExistByPackageBundleSpecification
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
        $this->isExist($package);
    }

    public function isExist(string $package): void
    {
        if (\is_null($this->bundles->findByPackageName($package))) {
            throw new NotFoundException(sprintf($this->translator->trans('zentlix_main.bundle.not_exist'), $package));
        }
    }
}
