<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Template\Specification;

use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Template\Repository\TemplateRepository;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

final class ExistTemplateSpecification
{
    private TranslatorInterface $translator;
    private TemplateRepository $templateRepository;

    public function __construct(TranslatorInterface $translator, TemplateRepository $templateRepository)
    {
        $this->translator = $translator;
        $this->templateRepository = $templateRepository;
    }

    public function __invoke($template): void
    {
        $this->isExist($template);
    }

    public function isExist($template): void
    {
        if (\is_null($this->templateRepository->find($template))) {
            throw new NotFoundException(
                sprintf($this->translator->trans('zentlix_main.template.not_exist'), $template)
            );
        }
    }
}
