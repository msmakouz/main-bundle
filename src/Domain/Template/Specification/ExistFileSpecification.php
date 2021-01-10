<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Template\Specification;

use Symfony\Contracts\Translation\TranslatorInterface;

final class ExistFileSpecification
{
    private TranslatorInterface $translator;
    private string $projectDir;

    public function __construct(TranslatorInterface $translator, string $projectDir)
    {
        $this->translator = $translator;
        $this->projectDir = $projectDir;
    }

    public function isExist(string $file): void
    {
        if(is_file($this->projectDir . '/templates/' . $file) === false) {
            throw new \DomainException(sprintf($this->translator->trans('zentlix_main.template.file_not_exist'), $file));
        }
    }

    public function __invoke(string $file): void
    {
        $this->isExist($file);
    }
}