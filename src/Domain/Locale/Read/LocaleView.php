<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Locale\Read;

class LocaleView
{
    public function __construct($id, $code, $title, $icon, $sort)
    {
        $this->id    = (int) $id;
        $this->code  = (string) $code;
        $this->title = (string) $title;
        $this->icon  = (string) $icon;
        $this->sort  = (int) $sort;
    }

    public int $id;
    public string $code;
    public string $title;
    public ?string $icon;
    public int $sort;
}