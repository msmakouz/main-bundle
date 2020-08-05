<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Locale\Entity;

use Doctrine\ORM\Mapping;
use Zentlix\MainBundle\Application\Command\Locale\CreateCommand;
use Zentlix\MainBundle\Application\Command\Locale\UpdateCommand;
use Zentlix\MainBundle\Domain\Shared\Entity\Eventable;
use Zentlix\MainBundle\Domain\Shared\Entity\SortTrait;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository")
 * @Mapping\Table(name="zentlix_main_locales", uniqueConstraints={
 *     @Mapping\UniqueConstraint(columns={"code"})
 * })
 */
class Locale implements Eventable
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

    /** @Mapping\Column(type="string", unique=true) */
    private $code;

    /** @Mapping\Column(type="string", length=255, nullable=true) */
    private $icon;

    public function __construct(CreateCommand $command)
    {
        $this->title = $command->title;
        $this->code = $command->code;
        $this->sort = $command->sort;
        $this->icon = $command->icon;
    }

    public function update(UpdateCommand $command)
    {
        $this->title = $command->title;
        $this->sort = $command->sort;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }
}