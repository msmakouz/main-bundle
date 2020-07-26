<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Locale\Specification;

use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Application\Query\NotFoundException;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\MainBundle\Domain\Shared\Specification\AbstractSpecification;

final class ExistLocaleSpecification extends AbstractSpecification
{
    private $localeRepository;
    private $translator;

    public function __construct(LocaleRepository $localeRepository, TranslatorInterface $translator)
    {
        $this->localeRepository = $localeRepository;
        $this->translator = $translator;
    }

    public function isExist(int $localeId): bool
    {
        return $this->isSatisfiedBy($localeId);
    }

    public function isSatisfiedBy($value): bool
    {
        $locale = $this->localeRepository->find($value);

        if(!$locale) {
            throw new NotFoundException(\sprintf($this->translator->trans('zentlix_main.locale.not_exist'), $value));
        }

        return true;
    }

    public function __invoke(int $localeId)
    {
        return $this->isExist($localeId);
    }
}