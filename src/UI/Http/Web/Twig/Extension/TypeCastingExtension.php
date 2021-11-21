<?php

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
            new TwigFilter('object', fn (array $value) => (object) $value),
        ];
    }
}
