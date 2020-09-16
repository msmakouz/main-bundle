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

final class ExistTemplateFolderSpecification
{
    private TranslatorInterface $translator;
    private string $projectDir;

    public function __construct(TranslatorInterface $translator, string $projectDir)
    {
        $this->translator = $translator;
        $this->projectDir = $projectDir;
    }

    public function isExist(string $folder): void
    {
        if(is_dir($this->projectDir . '/templates/' . $folder) === false) {
            throw new \DomainException(sprintf($this->translator->trans('zentlix_main.template_folder_not_exist'), $folder));
        }
    }

    public function __invoke(string $folder): void
    {
        $this->isExist($folder);
    }
}