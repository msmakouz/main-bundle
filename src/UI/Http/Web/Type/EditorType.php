<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

class EditorType extends TextareaType
{
    public function getBlockPrefix()
    {
        return 'textarea';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('required', false);
        $resolver->setDefault('attr', [
            'class' => 'cke-editor',
        ]);
    }
}
