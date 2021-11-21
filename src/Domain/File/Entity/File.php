<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\File\Entity;

use Doctrine\ORM\Mapping;
use Symfony\Component\Uid\Uuid;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\File\Repository\FileRepository")
 * @Mapping\Table(name="zentlix_main_files")
 */
class File
{
    /**
     * @Mapping\Id
     * @Mapping\Column(type="uuid", unique=true)
     */
    private $id;

    /** @Mapping\Column(type="string", length=255, unique=true) */
    private $path;

    /** @Mapping\Column(type="boolean", options={"default": "1"}) */
    private $deleted;

    /** @Mapping\Column(type="string", length=255, nullable=true) */
    private $alt;

    /** @Mapping\Column(type="string", length=255, nullable=true) */
    private $title;

    public function __construct(string $path, string $alt = null, string $title = null)
    {
        if (false === mb_strpos($path, 'http:') && false === mb_strpos($path, 'https:')) {
            if ('/' !== $path[0]) {
                $path = '/' . $path;
            }
        }

        $path = str_replace('\\', '/', $path);

        $this->id = Uuid::v4();
        $this->path = $path;
        $this->alt = $alt;
        $this->title = $title;
        $this->deleted = true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function getAbsolutePath(): string
    {
        $path = $this->path;

        if (mb_strpos($path, 'http:') || mb_strpos($path, 'https:')) {
            return $path;
        }

        return dirname(__DIR__, 7) . '/' . 'public' . $path;
    }

    public function finishUpload(): self
    {
        $this->deleted = false;

        return $this;
    }

    public function setAlt(?string $alt = null): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function setTitle(?string $title = null): self
    {
        $this->title = $title;

        return $this;
    }
}
