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
use Symfony\Component\Form\ChoiceList\View\ChoiceGroupView;

class ChoiceTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form, array $extensions = [], $widget = null)
    {
        $formView = $form->createView();
        $choices = [];
        $titles = [];
        foreach ($formView->vars['choices'] as $choiceView) {
            if ($choiceView instanceof ChoiceGroupView) {
                foreach ($choiceView->choices as $choiceItem) {
                    $choices[] = $choiceItem->value;
                    $titles[] = $choiceItem->label;
                }
            } else {
                $choices[] = $choiceView->value;
                $titles[] = $choiceView->label;
            }
        }

        $schema = $this->transformSelect($form, $choices, $titles);

        $schema = $this->addCommonSpecs($form, $schema, $extensions, $widget);

        return $schema;
    }

    private function transformSelect(FormInterface $form, $choices, $titles)
    {
        $formView = $form->createView();
        $value = $form->getData();
        $val = [];
        if(is_array($value)) {
            foreach (array_keys($value) as $k => $v) {
                $val[] = (string) $v;
            }
        }

        $schema = [
            'enum' => $choices,
            'enum_titles' => $titles,
            'type' => 'array',
            'multiple' => (bool) $formView->vars['multiple'],
            'value' => is_array($value) ? $val : (string) $value,
            'disabled' => $form->isDisabled()
        ];

        if ($formView->vars['expanded']) {
            $formView->vars['multiple'] ? $schema['widget'] = 'choice-multiple-expanded' : $schema['widget'] = 'choice-expanded';
        }

        if(!empty($formView->vars['disabled_values'])) {
            $schema['disabled_values'] = $formView->vars['disabled_values'];
        }

        if(!empty($formView->vars['specification'])) {
            $schema['specification'] = $formView->vars['specification'];
        }

        if($form->getErrors()->count()) {
            foreach ($form->getErrors() as $error) {
                $schema['errors'][] = $error->getMessage();
            }
        }

        return $schema;
    }
}