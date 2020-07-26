<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\JsonTransformer;

use Symfony\Component\Form\FormInterface;
use Limenius\Liform\Transformer\AbstractTransformer as BaseAbstractTransformer;

abstract class AbstractTransformer extends BaseAbstractTransformer
{
    protected function addLabel(FormInterface $form, array $schema): array
    {
        if ($label = $form->getConfig()->getOption('label')) {
            $schema['title'] = $label;
        } else {
            $schema['title'] = $form->getName();
        }

        return $schema;
    }

    protected function addDescription(FormInterface $form, array $schema): array
    {
        if ($zentlix = $form->getConfig()->getOption('zentlix')) {
            if (isset($zentlix['description']) && $description = $zentlix['description']) {
                $schema['description'] = $description;
            }
        }

        return $schema;
    }
}