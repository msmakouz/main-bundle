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

use Doctrine\ORM\NonUniqueResultException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Shared\Specification\AbstractSpecification;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;

final class UniqueUrlSpecification extends AbstractSpecification
{
    private SiteRepository $siteRepository;
    private TranslatorInterface $translator;

    public function __construct(SiteRepository $siteRepository, TranslatorInterface $translator)
    {
        $this->siteRepository = $siteRepository;
        $this->translator = $translator;
    }

    public function isUnique(string $url): bool
    {
        return $this->isSatisfiedBy($url);
    }

    public function isSatisfiedBy($value): bool
    {
        if($this->siteRepository->hasByUrl($value)) {
            throw new NonUniqueResultException(\sprintf($this->translator->trans('zentlix_main.site.already_exist'), $value));
        }

        return true;
    }

    public function __invoke(string $url)
    {
        return $this->isUnique($url);
    }
}