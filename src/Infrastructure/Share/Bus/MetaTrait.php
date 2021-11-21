<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Share\Bus;

use Zentlix\MainBundle\Domain\Shared\ValueObject\Meta;

trait MetaTrait
{
    protected ?Meta $meta = null;

    public function setMetaTitle(string $title = null): void
    {
        $this->initialize();

        $this->meta->title = $title;
    }

    public function setMetaDescription(string $description = null): void
    {
        $this->initialize();

        $this->meta->description = $description;
    }

    public function setMetaKeywords(string $keywords = null): void
    {
        $this->initialize();

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
        $this->initialize();

        $this->meta->title = $title;
        $this->meta->description = $description;
        $this->meta->keywords = $keywords;
    }

    private function initialize(): void
    {
        if (!$this->meta instanceof Meta) {
            $this->meta = new Meta();
        }
    }
}
