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
use Zentlix\MainBundle\Domain\Shared\Specification\AbstractSpecification;

final class ExistTemplateFileSpecification extends AbstractSpecification
{
    private TranslatorInterface $translator;
    private string $projectDir;

    public function __construct(TranslatorInterface $translator, string $projectDir)
    {
        $this->translator = $translator;
        $this->projectDir = $projectDir;
    }

    public function isExist(string $file): bool
    {
        return $this->isSatisfiedBy($file);
    }

    public function isSatisfiedBy($value): bool
    {
        if(is_file($this->projectDir . '/templates/' . $value) === false) {
            throw new \DomainException(sprintf($this->translator->trans('zentlix_main.template_file_not_exist'), $value));
        }

        return true;
    }

    public function __invoke(string $file)
    {
        return $this->isExist($file);
    }
}