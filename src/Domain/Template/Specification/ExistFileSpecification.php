<?php

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

    public function __invoke(string $file): void
    {
        $this->isExist($file);
    }

    public function isExist(string $file): void
    {
        if (false === is_file($this->projectDir . '/templates/' . $file)) {
            throw new \DomainException(
                sprintf($this->translator->trans('zentlix_main.template.file_not_exist'), $file)
            );
        }
    }
}
