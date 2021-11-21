<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Locale\Specification;

use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

final class ExistLocaleSpecification
{
    private LocaleRepository $localeRepository;
    private TranslatorInterface $translator;

    public function __construct(LocaleRepository $localeRepository, TranslatorInterface $translator)
    {
        $this->localeRepository = $localeRepository;
        $this->translator = $translator;
    }

    public function __invoke($localeId): void
    {
        $this->isExist($localeId);
    }

    public function isExist($localeId): void
    {
        if (\is_null($this->localeRepository->find($localeId))) {
            throw new NotFoundException(\sprintf($this->translator->trans('zentlix_main.locale.not_exist'), $localeId));
        }
    }
}
