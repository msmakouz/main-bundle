<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class UploadCommand implements CommandInterface
{
    public string $savePath;
    public ?string $filename;
    public ?string $alt = null;
    public ?string $title = null;
    public $id;
    public UploadedFile $uploadedFile;

    public function __construct(UploadedFile $file, string $savePath = '')
    {
        $this->savePath = $savePath;
        $this->uploadedFile = $file;
        $this->filename = $file->getClientOriginalName();
    }
}