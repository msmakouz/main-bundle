<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Entity;

use Doctrine\ORM\Mapping;
use Zentlix\MainBundle\Domain\Shared\ValueObject\Meta;

trait MetaTrait
{
    /**
     * @var Meta
     * @Mapping\Column(type="meta", nullable=true)
     */
    private $meta;

    public function getMetaTitle(): ?string
    {
        return $this->meta['title'] ?? null;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta['description'] ?? null;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->meta['keywords'] ?? null;
    }

    public function setMetaTitle(string $title): self
    {
        $this->meta['title'] = $title;

        return $this;
    }

    public function setMetaDescription(string $description): self
    {
        $this->meta['description'] = $description;

        return $this;
    }

    public function setMetaKeywords(string $keywords): self
    {
        $this->meta['keywords'] = $keywords;

        return $this;
    }
}