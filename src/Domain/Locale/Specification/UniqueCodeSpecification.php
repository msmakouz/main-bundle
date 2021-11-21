<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Locale\Specification;

use Doctrine\ORM\NonUniqueResultException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;

final class UniqueCodeSpecification
{
    private LocaleRepository $localeRepository;
    private TranslatorInterface $translator;

    public function __construct(LocaleRepository $localeRepository, TranslatorInterface $translator)
    {
        $this->localeRepository = $localeRepository;
        $this->translator = $translator;
    }

    public function __invoke(string $code): void
    {
        $this->isUnique($code);
    }

    public function isUnique(string $code): void
    {
        if (false === is_null($this->localeRepository->findOneByCode($code))) {
            throw new NonUniqueResultException(
                sprintf($this->translator->trans('zentlix_main.locale.already_exist'), $code)
            );
        }
    }
}
