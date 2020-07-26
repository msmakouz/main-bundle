<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\DataTable\Column;

use Omines\DataTablesBundle\Column\TextColumn as BaseTextColumn;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextColumn extends BaseTextColumn
{
    public function isNeedTranslate(): bool
    {
        return $this->options['translate'] ?? false;
    }

    protected function configureOptions(OptionsResolver $resolver): self
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefault('translate', false)
            ->setAllowedTypes('translate', 'bool');

        return $this;
    }
}