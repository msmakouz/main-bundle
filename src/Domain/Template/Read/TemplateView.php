<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Template\Read;

class TemplateView
{
    public function __construct($id, $title, $folder, $sort)
    {
        $this->id     = (int) $id;
        $this->title  = (string) $title;
        $this->folder = (string) $folder;
        $this->sort   = (int) $sort;
    }

    public int $id;
    public string $title;
    public string $folder;
    public int $sort;
}