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

class BooleanTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form, array $extensions = [], $widget = null)
    {
        $formView = $form->createView();

        $schema = ['type' => 'boolean'];
        $schema = $this->addCommonSpecs($form, $schema, $extensions, $widget);

        $schema['value'] = $form->getData();
        $schema['disabled'] = $form->isDisabled();

        if($form->getErrors()->count()) {
            foreach ($form->getErrors() as $error) {
                $schema['errors'][] = $error->getMessage();
            }
        }

        if(!empty($formView->vars['specification'])) {
            $schema['specification'] = $formView->vars['specification'];
        }

        if(!empty($formView->vars['update'])) {
            $schema['update'] = $formView->vars['update'];
        }

        return $schema;
    }
}