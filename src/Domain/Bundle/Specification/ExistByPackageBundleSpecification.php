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
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;
use function is_null;

final class ExistByPackageBundleSpecification
{
    private Bundles $bundles;
    private TranslatorInterface $translator;

    public function __construct(Bundles $bundles, TranslatorInterface $translator)
    {
        $this->bundles = $bundles;
        $this->translator = $translator;
    }

    public function isExist(string $package): void
    {
        if(is_null($this->bundles->findByPackageName($package))) {
            throw new NotFoundException(sprintf($this->translator->trans('zentlix_main.bundle.not_exist'), $package));
        }
    }

    public function __invoke(string $package): void
    {
        $this->isExist($package);
    }
}