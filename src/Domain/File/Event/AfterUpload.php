<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\File\Event;

use Zentlix\MainBundle\Domain\File\Entity\File;

final class AfterUpload
{
    private File $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function getFile(): File
    {
        return $this->file;
    }
}
