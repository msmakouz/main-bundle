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
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;

final class IsNotSystemSpecification
{
    private BundleRepository $bundleRepository;
    private TranslatorInterface $translator;

    public function __construct(BundleRepository $bundleRepository, TranslatorInterface $translator)
    {
        $this->translator = $translator;
        $this->bundleRepository = $bundleRepository;
    }

    public function isNotSystem($id): void
    {
        if($this->bundleRepository->get($id)->isSystem()) {
            throw new \DomainException($this->translator->trans('zentlix_main.bundle.system_bundle'));
        }
    }

    public function __invoke($id): void
    {
        $this->isNotSystem($id);
    }
}
