<?php

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

    public function __invoke($id): void
    {
        $this->isNotSystem($id);
    }

    public function isNotSystem($id): void
    {
        if ($this->bundleRepository->get($id)->isSystem()) {
            throw new \DomainException($this->translator->trans('zentlix_main.bundle.system_bundle'));
        }
    }
}
