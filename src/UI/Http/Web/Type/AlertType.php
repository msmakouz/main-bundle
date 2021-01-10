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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
Use Symfony\Component\OptionsResolver\OptionsResolver;

class AlertType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined('type');
        $resolver->setDefaults([
            'disabled' => true,
            'required' => false,
            'mapped'   => false,
            'label'    => false,
            'type'     => 'info'
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_merge($view->vars, [
            'type' => $options['type']
        ]);
    }

    public function getBlockPrefix()
    {
        return 'alert';
    }
}