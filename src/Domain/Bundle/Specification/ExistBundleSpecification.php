<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Specification;

use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

final class ExistBundleSpecification
{
    private BundleRepository $bundleRepository;
    private TranslatorInterface $translator;

    public function __construct(BundleRepository $bundleRepository, TranslatorInterface $translator)
    {
        $this->bundleRepository = $bundleRepository;
        $this->translator = $translator;
    }

    public function __invoke($bundleId): void
    {
        $this->isExist($bundleId);
    }

    public function isExist($bundleId): void
    {
        if (\is_null($this->bundleRepository->find($bundleId))) {
            throw new NotFoundException(sprintf($this->translator->trans('zentlix_main.bundle.not_exist'), $bundleId));
        }
    }
}
