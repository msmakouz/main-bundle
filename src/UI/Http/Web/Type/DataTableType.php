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
Use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class DataTableType extends AbstractType
{
    public function getBlockPrefix(): string
    {
        return 'datatable';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined(['displayedColumns', 'columnLabels', 'pageSizeOptions', 'pageSize', 'actionUrl', 'actionTitle']);
        $resolver->setDefaults([
            'required' => false,
            'displayedColumns' => [],
            'columnLabels' => [],
            'pageSizeOptions' => [10, 25, 50, 100, 300],
            'pageSize' => 25,
            'actionUrl' => null,
            'actionTitle' => null,
            'allow_extra_fields' => true
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_merge($view->vars, [
            'displayedColumns' => $options['displayedColumns'],
            'columnLabels' => $options['columnLabels'],
            'pageSizeOptions' => $options['pageSizeOptions'],
            'pageSize' => $options['pageSize'],
            'actionUrl' => $options['actionUrl'],
            'actionTitle' => $options['actionTitle'],
            'allow_extra_fields' => $options['allow_extra_fields']
        ]);
    }
}