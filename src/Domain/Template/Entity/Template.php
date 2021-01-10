<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Template\Entity;

use Doctrine\ORM\Mapping;
use Symfony\Component\Yaml\Yaml;
use Zentlix\MainBundle\Application\Command\Template\UpdateCommand;
use Zentlix\MainBundle\Domain\Shared\Entity\Eventable;
use Zentlix\MainBundle\Domain\Shared\Entity\SortTrait;
use Zentlix\MainBundle\Infrastructure\Attribute\Entity\SupportAttributeInterface;
use Zentlix\MainBundle\Infrastructure\Share\Helper\ArrayHelper;
use Zentlix\MainBundle\Application\Command\Template\CreateCommand;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\Template\Repository\TemplateRepository")
 * @Mapping\Table(name="zentlix_main_templates")
 * })
 */
class Template implements Eventable, SupportAttributeInterface
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

    public function __construct(CreateCommand $command)
    {
        $this->title = $command->title;
        $this->folder = $command->folder;
        $this->sort = $command->sort;
    }

    public function update(UpdateCommand $command): void
    {
        $this->title = $command->title;
        $this->sort = $command->sort;
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

        if(!is_array($config)) {
            return $default;
        }

        return ArrayHelper::get($config, $param, $default);
    }

    public static function getEntityCode(): string
    {
        return 'template';
    }

    public static function getEntityTitle(): string
    {
        return 'zentlix_main.template.site_template';
    }
}