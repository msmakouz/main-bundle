<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Widget\Admin;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DropzoneSettings extends AbstractExtension
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('dropzone_settings', fn (array $form) =>
                json_encode([
                    'url'                          => $form['url'],
                    'method'                       => $form['method'],
                    'withCredentials'              => $form['withCredentials'],
                    'timeout'                      => $form['timeout'],
                    'parallelUploads'              => $form['parallelUploads'],
                    'uploadMultiple'               => $form['uploadMultiple'],
                    'chunking'                     => $form['chunking'],
                    'forceChunking'                => $form['forceChunking'],
                    'chunkSize'                    => $form['chunkSize'],
                    'parallelChunkUploads'         => $form['parallelChunkUploads'],
                    'retryChunks'                  => $form['retryChunks'],
                    'retryChunksLimit'             => $form['retryChunksLimit'],
                    'maxFilesize'                  => $form['maxFilesize'],
                    'paramName'                    => $form['paramName'],
                    'createImageThumbnails'        => $form['createImageThumbnails'],
                    'maxThumbnailFilesize'         => $form['maxThumbnailFilesize'],
                    'thumbnailWidth'               => $form['thumbnailWidth'],
                    'thumbnailHeight'              => $form['thumbnailHeight'],
                    'thumbnailMethod'              => $form['thumbnailMethod'],
                    'resizeWidth'                  => $form['resizeWidth'],
                    'resizeHeight'                 => $form['resizeHeight'],
                    'resizeMimeType'               => $form['resizeMimeType'],
                    'resizeQuality'                => $form['resizeQuality'],
                    'resizeMethod'                 => $form['resizeMethod'],
                    'filesizeBase'                 => $form['filesizeBase'],
                    'maxFiles'                     => $form['maxFiles'],
                    'headers'                      => $form['headers'],
                    'clickable'                    => $form['clickable'],
                    'ignoreHiddenFiles'            => $form['ignoreHiddenFiles'],
                    'acceptedFiles'                => $form['acceptedFiles'],
                    'autoProcessQueue'             => $form['autoProcessQueue'],
                    'autoQueue'                    => $form['autoQueue'],
                    'addRemoveLinks'               => $form['addRemoveLinks'],
                    'previewsContainer'            => $form['previewsContainer'],
                    'hiddenInputContainer'         => $form['hiddenInputContainer'],
                    'capture'                      => $form['capture'],
                    'renameFile'                   => $form['renameFile'],
                    'forceFallback'                => $form['forceFallback'],
                    'dictDefaultMessage'           => $form['dictDefaultMessage'] ?? $this->translator->trans('zentlix_main.dropzone.default_message'),
                    'dictFallbackMessage'          => $form['dictFallbackMessage'] ?? $this->translator->trans('zentlix_main.dropzone.fallback_message'),
                    'dictFallbackText'             => $form['dictFallbackText'] ?? $this->translator->trans('zentlix_main.dropzone.fallback_text'),
                    'dictFileTooBig'               => $form['dictFileTooBig'] ?? $this->translator->trans('zentlix_main.dropzone.file_too_big'),
                    'dictInvalidFileType'          => $form['dictInvalidFileType'] ?? $this->translator->trans('zentlix_main.dropzone.invalid_file_type'),
                    'dictResponseError'            => $form['dictResponseError'] ?? $this->translator->trans('zentlix_main.dropzone.response_error'),
                    'dictCancelUpload'             => $form['dictCancelUpload'] ?? $this->translator->trans('zentlix_main.dropzone.cancel_upload'),
                    'dictUploadCanceled'           => $form['dictUploadCanceled'] ?? $this->translator->trans('zentlix_main.dropzone.upload_canceled'),
                    'dictCancelUploadConfirmation' => $form['dictCancelUploadConfirmation'] ?? $this->translator->trans('zentlix_main.dropzone.cancel_upload_confirmation'),
                    'dictRemoveFile'               => $form['dictRemoveFile'] ?? $this->translator->trans('zentlix_main.dropzone.remove_file'),
                    'dictMaxFilesExceeded'         => $form['dictMaxFilesExceeded'] ?? $this->translator->trans('zentlix_main.dropzone.max_files_exceeded'),
                    'dictFileSizeUnits'            => [
                        'tb' => 'TB',
                        'gb' => 'GB',
                        'mb' => 'MB',
                        'kb' => 'KB',
                        'b'  => 'b'
                    ],
                    'params'                       => [
                        'savePath' => $form['savePath']
                    ]
                ]), ['is_safe' => ['html']]),
        ];
    }
}