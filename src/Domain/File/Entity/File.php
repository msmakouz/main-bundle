<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\File\Entity;

use Doctrine\ORM\Mapping;
use Zentlix\MainBundle\Infrastructure\Share\Doctrine\Uuid;
use Zentlix\MainBundle\Infrastructure\Share\Doctrine\UuidInterface;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\File\Repository\FileRepository")
 * @Mapping\Table(name="zentlix_main_files")
 */
class File
{
    /**
     * @var UuidInterface
     * @Mapping\Id
     * @Mapping\Column(type="uuid_binary")
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
        if(strpos($path, 'http:') === false && strpos($path, 'https:') === false) {
            if($path[0] !== '/') {
                $path = '/' . $path;
            }
        }

        $path = str_replace('\\', '/', $path);

        $this->id = Uuid::uuid4();
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

        if(strpos($path, 'http:') || strpos($path, 'https:')) {
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