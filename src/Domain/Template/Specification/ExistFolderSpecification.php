<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Template\Specification;

use Symfony\Contracts\Translation\TranslatorInterface;

final class ExistFolderSpecification
{
    private TranslatorInterface $translator;
    private string $projectDir;

    public function __construct(TranslatorInterface $translator, string $projectDir)
    {
        $this->translator = $translator;
        $this->projectDir = $projectDir;
    }

    public function __invoke(string $folder): void
    {
        $this->isExist($folder);
    }

    public function isExist(string $folder): void
    {
        if (false === is_dir($this->projectDir . '/templates/' . $folder)) {
            throw new \DomainException(
                sprintf($this->translator->trans('zentlix_main.template.folder_not_exist'), $folder)
            );
        }
    }
}
