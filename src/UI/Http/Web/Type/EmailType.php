<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Type;

use Symfony\Component\Form\Extension\Core\Type\EmailType as BaseEmailType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailType extends BaseEmailType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefined(['specification', 'prepend', 'append']);
        $resolver->setDefaults([
            'specification' => null,
            'append' => null,
            'prepend' => null,
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_merge($view->vars, [
            'specification' => $options['specification'],
            'append' => $options['append'],
            'prepend' => $options['prepend'],
        ]);
    }
}
