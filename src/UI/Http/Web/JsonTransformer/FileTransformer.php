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
use Symfony\Component\HttpFoundation\File\File;

class FileTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form, array $extensions = [], $widget = null)
    {
        $schema = ['type' => 'file'];
        $schema = $this->addCommonSpecs($form, $schema, $extensions, $widget);
        $schema['value'] = null;
        $value = $form->getData();

        if(is_null($value) === false && is_array($value) === false) {
            $value = [$value];
        }

        if(is_array($value)) {
            foreach ($value as $fileEntity) {
                $file = new File($fileEntity->getAbsolutePath());
                $schema['value'][] = [
                    'id'        => $fileEntity->getId(),
                    'name'      => $file->getFilename(),
                    'path'      => $fileEntity->getPath(),
                    'mime'      => $file->getMimeType(),
                    'size'      => $file->getSize(),
                    'extension' => $file->getExtension()
                ];
            }
        }

        if($form->getErrors()->count()) {
            foreach ($form->getErrors() as $error) {
                $schema['errors'][] = $error->getMessage();
            }
        }

        $formView = $form->createView();

        $schema['config'] = [
            'addRemoveLinks'    => $formView->vars['addRemoveLinks'],
            'acceptedFiles'     => $formView->vars['acceptedFiles'],
            'autoReset'         => $formView->vars['autoReset'],
            'timeout'           => $formView->vars['timeout'],
            'errorReset'        => $formView->vars['errorReset'],
            'cancelReset'       => $formView->vars['cancelReset'],
            'url'               => $formView->vars['url'],
            'method'            => $formView->vars['method'],
            'previewsContainer' => $formView->vars['previewsContainer'],
            'maxFiles'          => $formView->vars['maxFiles'],
            'maxFilesize'       => $formView->vars['maxFilesize'],
            'uploadMultiple'    => $formView->vars['uploadMultiple'],
            'thumbnailWidth'    => $formView->vars['thumbnailWidth'],
            'thumbnailHeight'   => $formView->vars['thumbnailHeight'],
            'thumbnailMethod'   => $formView->vars['thumbnailMethod'],
        ];

        if(!empty($formView->vars['savePath'])) {
            $schema['savePath'] = $formView->vars['savePath'];
        }

        return $schema;
    }
}