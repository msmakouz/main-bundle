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

class DataTableTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form, array $extensions = [], $widget = null)
    {
        $schema = ['type' => 'datatable'];
        $schema = $this->addCommonSpecs($form, $schema, $extensions, $widget);
        $schema['value'] = $form->getData();

        if($form->getErrors()->count()) {
            foreach ($form->getErrors() as $error) {
                $schema['errors'][] = $error->getMessage();
            }
        }

        $formView = $form->createView();

        if(\count($formView->vars['displayedColumns']) > 0) {
            $schema['displayedColumns'] = $formView->vars['displayedColumns'];
        }
        if(\count($formView->vars['columnLabels']) > 0) {
            $schema['columnLabels'] = $formView->vars['columnLabels'];
        }
        if(!empty($formView->vars['pageSizeOptions'])) {
            $schema['pageSizeOptions'] = $formView->vars['pageSizeOptions'];
        }
        if(!empty($formView->vars['pageSize'])) {
            $schema['pageSize'] = $formView->vars['pageSize'];
        }
        if(!empty($formView->vars['actionUrl'])) {
            $schema['actionUrl'] = $formView->vars['actionUrl'];
        }
        if(!empty($formView->vars['actionTitle'])) {
            $schema['actionTitle'] = $formView->vars['actionTitle'];
        }

        return $schema;
    }
}