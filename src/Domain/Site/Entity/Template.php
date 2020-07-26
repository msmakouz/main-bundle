<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Entity;

use Doctrine\ORM\Mapping;
use Symfony\Component\Yaml\Yaml;
use Zentlix\MainBundle\Domain\Shared\Entity\SortTrait;
use Zentlix\MainBundle\Infrastructure\Share\Helper\ArrayHelper;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\Site\Repository\TemplateRepository")
 * @Mapping\Table(name="zx_templates")
 * })
 */
class Template
{
    use SortTrait;

    /**
     * @Mapping\Id()
     * @Mapping\GeneratedValue()
     * @Mapping\Column(type="integer")
     */
    private $id;

    /** @Mapping\Column(type="string", length=255) */
    private $title;

    /** @Mapping\Column(type="string", length=255) */
    private $folder;

    private $config;

    public function __construct($title, $folder, $sort)
    {
        $this->title = $title;
        $this->folder = $folder;
        $this->sort = $sort;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFolder(string $folder): void
    {
        $this->folder = $folder;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getFolder(): string
    {
        return $this->folder;
    }

    public function getConfigParam(string $param, $default = null)
    {
        $config = Yaml::parseFile(dirname(__DIR__, 7) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $this->folder .
            DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'config.yaml');

        return ArrayHelper::get($config, $param, $default);
    }
}