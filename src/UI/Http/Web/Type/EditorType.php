<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

class EditorType extends TextareaType
{
    public function getBlockPrefix()
    {
        return 'textarea';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('required', false);
        $resolver->setDefault('attr', [
            'class' => 'cke-editor'
        ]);
    }
}