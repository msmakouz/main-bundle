<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Type;

use Symfony\Component\Form\Extension\Core\Type\TextareaType as BaseTextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextareaType extends BaseTextareaType
{
    public function getBlockPrefix()
    {
        return 'textarea';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefined('specification');
        $resolver->setDefault('specification', null);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_merge($view->vars, [
            'specification' => $options['specification'],
        ]);
    }
}
