<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileStorageType extends AbstractType
{
    private const DEFAULT_UPLOAD_PATH = '/backend/file/upload';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (PreSubmitEvent $event): void {
            $event->getForm()->setData($event->getData());
        });
    }

    public function getBlockPrefix(): string
    {
        return 'file_storage';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined([
            'url',
            'method',
            'withCredentials',
            'timeout',
            'parallelUploads',
            'uploadMultiple',
            'chunking',
            'forceChunking',
            'chunkSize',
            'parallelChunkUploads',
            'retryChunks',
            'retryChunksLimit',
            'maxFilesize',
            'paramName',
            'createImageThumbnails',
            'maxThumbnailFilesize',
            'thumbnailWidth',
            'thumbnailHeight',
            'thumbnailMethod',
            'resizeWidth',
            'resizeHeight',
            'resizeMimeType',
            'resizeQuality',
            'resizeMethod',
            'filesizeBase',
            'maxFiles',
            'headers',
            'clickable',
            'ignoreHiddenFiles',
            'acceptedFiles',
            'autoProcessQueue',
            'autoQueue',
            'addRemoveLinks',
            'previewsContainer',
            'hiddenInputContainer',
            'capture',
            'renameFile',
            'forceFallback',
            'dictDefaultMessage',
            'dictFallbackMessage',
            'dictFallbackText',
            'dictFileTooBig',
            'dictInvalidFileType',
            'dictResponseError',
            'dictCancelUpload',
            'dictUploadCanceled',
            'dictCancelUploadConfirmation',
            'dictRemoveFile',
            'dictMaxFilesExceeded',
            'savePath',
            'required',
            'multiple',
        ]);

        $resolver->setDefaults([
            'url' => self::DEFAULT_UPLOAD_PATH,
            'method' => Request::METHOD_POST,
            'withCredentials' => false,
            'timeout' => 30000,
            'parallelUploads' => 1,
            'uploadMultiple' => false,
            'chunking' => false,
            'forceChunking' => false,
            'chunkSize' => 2000000,
            'parallelChunkUploads' => false,
            'retryChunks' => false,
            'retryChunksLimit' => 3,
            'maxFilesize' => 256,
            'paramName' => 'file',
            'createImageThumbnails' => true,
            'maxThumbnailFilesize' => 10,
            'thumbnailWidth' => 250,
            'thumbnailHeight' => 250,
            'thumbnailMethod' => 'contain',
            'resizeWidth' => null,
            'resizeHeight' => null,
            'resizeMimeType' => null,
            'resizeQuality' => 0.8,
            'resizeMethod' => 'contain',
            'filesizeBase' => 1000,
            'maxFiles' => 1,
            'headers' => null,
            'clickable' => true,
            'ignoreHiddenFiles' => true,
            'acceptedFiles' => null,
            'autoProcessQueue' => true,
            'autoQueue' => true,
            'addRemoveLinks' => true,
            'previewsContainer' => null,
            'hiddenInputContainer' => 'body',
            'capture' => null,
            'renameFile' => null,
            'forceFallback' => false,
            'dictDefaultMessage' => null,
            'dictFallbackMessage' => null,
            'dictFallbackText' => null,
            'dictFileTooBig' => null,
            'dictInvalidFileType' => null,
            'dictResponseError' => null,
            'dictCancelUpload' => null,
            'dictUploadCanceled' => null,
            'dictCancelUploadConfirmation' => null,
            'dictRemoveFile' => null,
            'dictMaxFilesExceeded' => null,
            'savePath' => null,
            'required' => false,
            'multiple' => false,
            'allow_extra_fields' => true,
            'compound' => false,
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars = array_merge($view->vars, [
            'url' => $options['url'],
            'method' => $options['method'],
            'withCredentials' => $options['withCredentials'],
            'timeout' => $options['timeout'],
            'parallelUploads' => $options['parallelUploads'],
            'uploadMultiple' => $options['uploadMultiple'],
            'chunking' => $options['chunking'],
            'forceChunking' => $options['forceChunking'],
            'chunkSize' => $options['chunkSize'],
            'parallelChunkUploads' => $options['parallelChunkUploads'],
            'retryChunks' => $options['retryChunks'],
            'retryChunksLimit' => $options['retryChunksLimit'],
            'maxFilesize' => $options['maxFilesize'],
            'paramName' => $options['paramName'],
            'createImageThumbnails' => $options['createImageThumbnails'],
            'maxThumbnailFilesize' => $options['maxThumbnailFilesize'],
            'thumbnailWidth' => $options['thumbnailWidth'],
            'thumbnailHeight' => $options['thumbnailHeight'],
            'thumbnailMethod' => $options['thumbnailMethod'],
            'resizeWidth' => $options['resizeWidth'],
            'resizeHeight' => $options['resizeHeight'],
            'resizeMimeType' => $options['resizeMimeType'],
            'resizeQuality' => $options['resizeQuality'],
            'resizeMethod' => $options['resizeMethod'],
            'filesizeBase' => $options['filesizeBase'],
            'maxFiles' => $options['maxFiles'],
            'headers' => $options['headers'],
            'clickable' => $options['clickable'],
            'ignoreHiddenFiles' => $options['ignoreHiddenFiles'],
            'acceptedFiles' => $options['acceptedFiles'],
            'autoProcessQueue' => $options['autoProcessQueue'],
            'autoQueue' => $options['autoQueue'],
            'addRemoveLinks' => $options['addRemoveLinks'],
            'previewsContainer' => $options['previewsContainer'],
            'hiddenInputContainer' => $options['hiddenInputContainer'],
            'capture' => $options['capture'],
            'renameFile' => $options['renameFile'],
            'forceFallback' => $options['forceFallback'],
            'dictDefaultMessage' => $options['dictDefaultMessage'],
            'dictFallbackMessage' => $options['dictFallbackMessage'],
            'dictFallbackText' => $options['dictFallbackText'],
            'dictFileTooBig' => $options['dictFileTooBig'],
            'dictInvalidFileType' => $options['dictInvalidFileType'],
            'dictResponseError' => $options['dictResponseError'],
            'dictCancelUpload' => $options['dictCancelUpload'],
            'dictUploadCanceled' => $options['dictUploadCanceled'],
            'dictCancelUploadConfirmation' => $options['dictCancelUploadConfirmation'],
            'dictRemoveFile' => $options['dictRemoveFile'],
            'dictMaxFilesExceeded' => $options['dictMaxFilesExceeded'],
            'savePath' => $options['savePath'],
            'required' => $options['required'],
            'multiple' => $options['multiple'],
            'allow_extra_fields' => $options['maxFiles'] > 1 ? true : false,
        ]);
    }
}
