<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Specification;

use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;
use function is_null;

final class ExistSiteSpecification
{
    private SiteRepository $siteRepository;
    private TranslatorInterface $translator;

    public function __construct(SiteRepository $siteRepository, TranslatorInterface $translator)
    {
        $this->siteRepository = $siteRepository;
        $this->translator = $translator;
    }

    public function isExist(int $siteId): void
    {
        if(is_null($this->siteRepository->find($siteId))) {
            throw new NotFoundException(\sprintf($this->translator->trans('zentlix_main.site.not_exist'), $siteId));
        }
    }

    public function __invoke(int $siteId): void
    {
        $this->isExist($siteId);
    }
}