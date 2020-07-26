<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command;

use Zentlix\MainBundle\Domain\Shared\ValueObject\Meta;

trait MetaTrait {

    protected Meta $meta;

    public function setMetaTitle(string $title = null): void
    {
        $this->meta->title = $title;
    }

    public function setMetaDescription(string $description = null): void
    {
        $this->meta->description = $description;
    }

    public function setMetaKeywords(string $keywords = null): void
    {
        $this->meta->keywords = $keywords;
    }

    public function getMetaTitle(): ?string
    {
        return $this->meta->title;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta->description;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->meta->keywords;
    }

    public function getMeta(): Meta
    {
        return $this->meta;
    }

    public function setMeta(string $title = null, string $description = null, string $keywords = null): void
    {
        $this->meta = new Meta();
        $this->meta->title = $title;
        $this->meta->description = $description;
        $this->meta->keywords = $keywords;
    }
}