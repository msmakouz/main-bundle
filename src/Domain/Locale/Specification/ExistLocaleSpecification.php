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
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;
use function is_null;

final class ExistLocaleSpecification
{
    private LocaleRepository $localeRepository;
    private TranslatorInterface $translator;

    public function __construct(LocaleRepository $localeRepository, TranslatorInterface $translator)
    {
        $this->localeRepository = $localeRepository;
        $this->translator = $translator;
    }

    public function isExist(int $localeId): void
    {
        if(is_null($this->localeRepository->find($localeId))) {
            throw new NotFoundException(\sprintf($this->translator->trans('zentlix_main.locale.not_exist'), $localeId));
        }
    }

    public function __invoke(int $localeId): void
    {
        $this->isExist($localeId);
    }
}