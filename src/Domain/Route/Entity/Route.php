<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Route\Entity;

use Doctrine\ORM\Mapping;
use Zentlix\MainBundle\Domain\Shared\Entity\Eventable;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Site\Entity\Site;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\Route\Repository\RouteRepository")
 * @Mapping\Table(name="zentlix_main_routes")
 */
class Route implements Eventable
{
    /**
     * @Mapping\Id()
     * @Mapping\GeneratedValue()
     * @Mapping\Column(type="integer")
     */
    private $id;

    /** @Mapping\Column(type="string", length=255) */
    private $url;

    /** @Mapping\Column(type="string", length=255) */
    private $controller;

    /** @Mapping\Column(type="string", length=255) */
    private $action;

    /** @Mapping\Column(type="string", length=255) */
    private $title;

    /** @Mapping\Column(type="string", length=255, nullable=true) */
    private $name;

    /**
     * @var Site
     * @Mapping\ManyToOne(targetEntity="Zentlix\MainBundle\Domain\Site\Entity\Site", inversedBy="routes")
     * @Mapping\JoinColumn(name="site_id", referencedColumnName="id", nullable=false)
     */
    private $site;

    /**
     * @var Bundle
     * @Mapping\ManyToOne(targetEntity="Zentlix\MainBundle\Domain\Bundle\Entity\Bundle")
     * @Mapping\JoinColumn(name="bundle_id", referencedColumnName="id", nullable=false)
     */
    private $bundle;

    public function __construct(string $url, string $controller, string $action, string $title, string $name = null)
    {
        if($url[0] === '/') {
            $url = substr($url, 1);
        }

        $this->url = $url;
        $this->controller = $controller;
        $this->action = $action;
        $this->title = $title;
        $this->name = $name;
    }

    public function setSite(Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function setBundle(Bundle $bundle): self
    {
        $this->bundle = $bundle;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getCleanUrl(): string
    {
        return self::cleanUrl($this->url);
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSite(): Site
    {
        return $this->site;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function isUrlEqual(string $url): bool
    {
        return self::cleanUrl($url) === self::cleanUrl($this->url);
    }

    public static function cleanUrl(string $url): string
    {
        return explode('{', $url)[0];
    }
}