<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class UploadCommand implements CommandInterface
{
    public ?string $filename;
    public ?string $alt = null;
    public ?string $title = null;
    public $id;

    public function __construct(
        public UploadedFile $uploadedFile,
        public string $savePath = ''
    ) {
        $this->filename = $uploadedFile->getClientOriginalName();
    }
}
