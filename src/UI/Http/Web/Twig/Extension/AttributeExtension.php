<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zentlix\MainBundle\Domain\Attribute\Service\Attributes;
use Zentlix\MainBundle\Domain\Site\Service\Sites;

final class AttributeExtension extends AbstractExtension
{
    private Sites $sites;
    private Attributes $attributes;

    public function __construct(Sites $sites, Attributes $attributes)
    {
        $this->sites = $sites;
        $this->attributes = $attributes;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('template_attribute', function ($code) {
                $templateId = $this->sites->getCurrentSite()->getTemplate()->getId()->toString();

                return $this->attributes->getTemplateAttribute($templateId, $code);
            }, ['needs_environment' => false])
        ];
    }
}