<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Locale\Read;

class LocaleView
{
    public string $id;
    public string $code;
    public string $title;
    public ?string $icon;
    public int $sort;

    public function __construct($id, $code, $title, $icon, $sort)
    {
        $this->id = (string) $id;
        $this->code = (string) $code;
        $this->title = (string) $title;
        $this->icon = (string) $icon;
        $this->sort = (int) $sort;
    }
}
