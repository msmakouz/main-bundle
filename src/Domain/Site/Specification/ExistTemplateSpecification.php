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
use Zentlix\MainBundle\Application\Query\NotFoundException;
use Zentlix\MainBundle\Domain\Shared\Specification\AbstractSpecification;
use Zentlix\MainBundle\Domain\Site\Repository\TemplateRepository;

final class ExistTemplateSpecification extends AbstractSpecification
{
    private TranslatorInterface $translator;
    private TemplateRepository $templateRepository;

    public function __construct(TranslatorInterface $translator, TemplateRepository $templateRepository)
    {
        $this->translator = $translator;
        $this->templateRepository = $templateRepository;
    }

    public function isExist($template): bool
    {
        return $this->isSatisfiedBy($template);
    }

    public function isSatisfiedBy($value): bool
    {
        $template = $this->templateRepository->find($value);

        if(!$template) {
            throw new NotFoundException(\sprintf($this->translator->trans('zentlix_main.site.template_not_exist'), $value));
        }

        return true;
    }

    public function __invoke($template)
    {
        return $this->isExist($template);
    }
}