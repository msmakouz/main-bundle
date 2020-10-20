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
use Zentlix\MainBundle\Domain\Site\Repository\TemplateRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;
use function is_null;

final class ExistTemplateSpecification
{
    private TranslatorInterface $translator;
    private TemplateRepository $templateRepository;

    public function __construct(TranslatorInterface $translator, TemplateRepository $templateRepository)
    {
        $this->translator = $translator;
        $this->templateRepository = $templateRepository;
    }

    public function isExist($template): void
    {
        if(is_null($this->templateRepository->find($template))) {
            throw new NotFoundException(sprintf($this->translator->trans('zentlix_main.site.template_not_exist'), $template));
        }
    }

    public function __invoke($template): void
    {
        $this->isExist($template);
    }
}