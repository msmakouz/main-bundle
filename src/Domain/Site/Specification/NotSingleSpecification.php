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
use Zentlix\MainBundle\Application\Query\NotFoundException;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;
use Zentlix\MainBundle\Domain\Shared\Specification\AbstractSpecification;

final class NotSingleSpecification extends AbstractSpecification
{
    private $siteRepository;
    private $translator;

    public function __construct(SiteRepository $siteRepository, TranslatorInterface $translator)
    {
        $this->siteRepository = $siteRepository;
        $this->translator = $translator;
    }

    public function isNotSingle(): bool
    {
        return $this->isSatisfiedBy('');
    }

    public function isSatisfiedBy($value): bool
    {
        if($this->siteRepository->isSingle()) {
            throw new NotFoundException($this->translator->trans('zentlix_main.site.is_single_site'));
        }

        return true;
    }

    public function __invoke()
    {
        return $this->isNotSingle();
    }
}