<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Read;

trait MetaViewTrait
{
    public ?string $meta_title;
    public ?string $meta_description;
    public ?string $meta_keywords;
    private ?string $meta;

    public function __construct()
    {
        if (is_null($this->meta) === false && $this->meta !== '') {
            if (is_resource($this->meta)) {
                $this->meta = stream_get_contents($this->meta);
            }

            $val = json_decode($this->meta, true);

            $this->meta_title = $val['title'] ?? null;
            $this->meta_description = $val['description'] ?? null;
            $this->meta_keywords = $val['keywords'] ?? null;
        }
    }
}