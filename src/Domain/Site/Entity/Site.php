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
use Zentlix\MainBundle\Application\Command\Site\CreateCommand;
use Zentlix\MainBundle\Application\Command\Site\UpdateCommand;
use Zentlix\MainBundle\Domain\Shared\Entity\Eventable;
use Zentlix\MainBundle\Domain\Shared\Entity\MetaTrait;
use Zentlix\MainBundle\Domain\Shared\Entity\SortTrait;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\Infrastructure\Attribute\Entity\SupportAttributeInterface;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\Site\Repository\SiteRepository")
 * @Mapping\Table(name="zentlix_main_sites", uniqueConstraints={
 *     @Mapping\UniqueConstraint(columns={"url"})
 * })
 */
class Site implements Eventable, SupportAttributeInterface
{
    use MetaTrait, SortTrait;

    /**
     * @Mapping\Id()
     * @Mapping\GeneratedValue()
     * @Mapping\Column(type="integer")
     */
    private $id;

    /** @Mapping\Column(type="string", length=255) */
    private $title;

    /** @Mapping\Column(type="string", unique=true) */
    private $url;

    /**
     * @var Locale
     * @Mapping\ManyToOne(targetEntity="Zentlix\MainBundle\Domain\Locale\Entity\Locale")
     * @Mapping\JoinColumn(name="locale_id", referencedColumnName="id", nullable=false)
     */
    private $locale;

    /**
     * @var Template
     * @Mapping\ManyToOne(targetEntity="Zentlix\MainBundle\Domain\Template\Entity\Template")
     * @Mapping\JoinColumn(name="template_id", referencedColumnName="id")
     */
    private $template;

    public function __construct(CreateCommand $command)
    {
        $this->setValuesFromCommands($command);
    }

    public function update(UpdateCommand $command): void
    {
        $this->setValuesFromCommands($command);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getLocale(): Locale
    {
        return $this->locale;
    }

    public function getTemplate(): Template
    {
        return $this->template;
    }

    public function setTemplate(Template $template): void
    {
        $this->template = $template;
    }

    public function setLocale(Locale $locale): void
    {
        $this->locale = $locale;
    }

    public function isUrlEqual(string $url): bool
    {
        return $this->url === $url;
    }

    public static function getEntityCode(): string
    {
        return 'site';
    }

    public static function getEntityTitle(): string
    {
        return 'zentlix_main.site.site';
    }

    /**
     * @param CreateCommand|UpdateCommand $command
     */
    private function setValuesFromCommands($command): void
    {
        $this->title = $command->title;
        $this->url = $command->url;
        $this->meta = $command->getMeta();
        $this->sort = $command->sort;
        $this->template = $command->template;
        $this->locale = $command->locale;
    }
}