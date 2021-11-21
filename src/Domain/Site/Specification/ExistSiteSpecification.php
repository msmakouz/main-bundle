<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Specification;

use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

final class ExistSiteSpecification
{
    private SiteRepository $siteRepository;
    private TranslatorInterface $translator;

    public function __construct(SiteRepository $siteRepository, TranslatorInterface $translator)
    {
        $this->siteRepository = $siteRepository;
        $this->translator = $translator;
    }

    public function __invoke($siteId): void
    {
        $this->isExist($siteId);
    }

    public function isExist($siteId): void
    {
        if (\is_null($this->siteRepository->find($siteId))) {
            throw new NotFoundException(\sprintf($this->translator->trans('zentlix_main.site.not_exist'), $siteId));
        }
    }
}
