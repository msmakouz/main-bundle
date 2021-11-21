<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Template\Read;

class TemplateView
{
    public string $id;
    public string $title;
    public string $folder;
    public int $sort;

    public function __construct($id, $title, $folder, $sort)
    {
        $this->id = (string) $id;
        $this->title = (string) $title;
        $this->folder = (string) $folder;
        $this->sort = (int) $sort;
    }
}
