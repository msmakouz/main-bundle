<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zentlix\MainBundle\Domain\Attribute\Service\Attributes;
use Zentlix\MainBundle\Domain\Site\Service\Sites;

final class AttributeExtension extends AbstractExtension
{
    public function __construct(
        private Sites $sites,
        private Attributes $attributes
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('template_attribute', function ($code) {
                $templateId = $this->sites->getCurrentSite()->getTemplate()->getId()->toRfc4122();

                return $this->attributes->getTemplateAttribute($templateId, $code);
            }, ['needs_environment' => false]),
        ];
    }
}
