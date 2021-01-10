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
use Twig\TwigFilter;

final class TypeCastingExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('int', fn ($value) => (int) $value),
            new TwigFilter('float', fn ($value) => (float) $value),
            new TwigFilter('string', fn ($value) => (string) $value),
            new TwigFilter('bool', fn ($value) => (bool) $value),
            new TwigFilter('array', fn (object $value) => (array) $value),
            new TwigFilter('object', fn (array $value) => (object) $value)
        ];
    }
}