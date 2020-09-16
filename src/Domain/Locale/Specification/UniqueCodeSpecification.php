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

use Doctrine\ORM\NonUniqueResultException;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use function is_null;

final class UniqueCodeSpecification
{
    private LocaleRepository $localeRepository;
    private TranslatorInterface $translator;

    public function __construct(LocaleRepository $localeRepository, TranslatorInterface $translator)
    {
        $this->localeRepository = $localeRepository;
        $this->translator = $translator;
    }

    public function isUnique(string $code): void
    {
        if(is_null($this->localeRepository->findOneByCode($code)) === false) {
            throw new NonUniqueResultException(sprintf($this->translator->trans('zentlix_main.locale.already_exist'), $code));
        }
    }

    public function __invoke(string $code): void
    {
        $this->isUnique($code);
    }
}