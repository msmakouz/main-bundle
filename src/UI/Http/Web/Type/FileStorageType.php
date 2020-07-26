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
use Symfony\Component\HttpFoundation\Request;
Use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class FileStorageType extends AbstractType
{
    private const DEFAULT_UPLOAD_PATH = '/backend/file/upload';

    public function getBlockPrefix(): string
    {
        return 'file';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined([
            'addRemoveLinks',
            'acceptedFiles',
            'autoReset',
            'timeout',
            'errorReset',
            'cancelReset',
            'url',
            'method',
            'previewsContainer',
            'maxFiles',
            'maxFilesize',
            'thumbnailWidth',
            'thumbnailHeight',
            'thumbnailMethod',
            'savePath'
        ]);

        $resolver->setDefaults([
            'compound'          => false,
            'required'          => false,
            'multiple'          => false,
            'addRemoveLinks'    => true,
            'acceptedFiles'     => null,
            'autoReset'         => null,
            'timeout'           => null,
            'errorReset'        => null,
            'cancelReset'       => null,
            'url'               => self::DEFAULT_UPLOAD_PATH,
            'method'            => Request::METHOD_POST,
            'previewsContainer' => null,
            'maxFiles'          => 1,
            'maxFilesize'       => null,
            'thumbnailWidth'    => 150,
            'thumbnailHeight'   => null,
            'thumbnailMethod'   => 'contain',
            'savePath'          => null
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_merge($view->vars, [
            'addRemoveLinks'    => $options['addRemoveLinks'],
            'acceptedFiles'     => $options['acceptedFiles'],
            'autoReset'         => $options['autoReset'],
            'timeout'           => $options['timeout'],
            'errorReset'        => $options['errorReset'],
            'cancelReset'       => $options['cancelReset'],
            'url'               => $options['url'],
            'method'            => $options['method'],
            'previewsContainer' => $options['previewsContainer'],
            'maxFiles'          => $options['multiple'] ? $options['maxFiles'] : 1,
            'maxFilesize'       => $options['maxFilesize'],
            'uploadMultiple'    => $options['multiple'],
            'thumbnailWidth'    => $options['thumbnailWidth'],
            'thumbnailHeight'   => $options['thumbnailHeight'],
            'thumbnailMethod'   => $options['thumbnailMethod'],
            'savePath'          => $options['savePath']
        ]);
    }
}