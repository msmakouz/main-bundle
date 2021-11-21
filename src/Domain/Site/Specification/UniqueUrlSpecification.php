<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Specification;

use Doctrine\ORM\NonUniqueResultException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;

final class UniqueUrlSpecification
{
    private SiteRepository $siteRepository;
    private TranslatorInterface $translator;

    public function __construct(SiteRepository $siteRepository, TranslatorInterface $translator)
    {
        $this->siteRepository = $siteRepository;
        $this->translator = $translator;
    }

    public function __invoke(string $url): void
    {
        $this->isUnique($url);
    }

    public function isUnique(string $url): void
    {
        if ($this->siteRepository->hasByUrl($url)) {
            throw new NonUniqueResultException(
                sprintf($this->translator->trans('zentlix_main.site.already_exist'), $url)
            );
        }
    }
}
