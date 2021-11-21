<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Specification;

use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

final class NotSingleSpecification
{
    private SiteRepository $siteRepository;
    private TranslatorInterface $translator;

    public function __construct(SiteRepository $siteRepository, TranslatorInterface $translator)
    {
        $this->siteRepository = $siteRepository;
        $this->translator = $translator;
    }

    public function __invoke(): void
    {
        $this->isNotSingle();
    }

    public function isNotSingle(): void
    {
        if ($this->siteRepository->isSingle()) {
            throw new NotFoundException($this->translator->trans('zentlix_main.site.is_single_site'));
        }
    }
}
