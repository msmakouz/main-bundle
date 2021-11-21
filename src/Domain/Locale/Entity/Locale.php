<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Locale\Entity;

use Doctrine\ORM\Mapping;
use Zentlix\MainBundle\Application\Command\Locale\CreateCommand;
use Zentlix\MainBundle\Application\Command\Locale\UpdateCommand;
use Zentlix\MainBundle\Domain\Shared\Entity\Eventable;
use Zentlix\MainBundle\Domain\Shared\Entity\SortTrait;
use Zentlix\MainBundle\Infrastructure\Attribute\Entity\SupportAttributeInterface;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository")
 * @Mapping\Table(name="zentlix_main_locales", uniqueConstraints={
 *     @Mapping\UniqueConstraint(columns={"code"})
 * })
 */
class Locale implements Eventable, SupportAttributeInterface
{
    use SortTrait;

    /**
     * @Mapping\Id
     * @Mapping\Column(type="uuid", unique=true)
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
        $this->id = $command->id;
        $this->title = $command->title;
        $this->code = $command->code;
        $this->sort = $command->sort;
        $this->icon = $command->icon;
    }

    public function update(UpdateCommand $command): void
    {
        $this->title = $command->title;
        $this->sort = $command->sort;
    }

    public function getId()
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

    public static function getEntityCode(): string
    {
        return 'locale';
    }

    public static function getEntityTitle(): string
    {
        return 'zentlix_main.locale.locale';
    }
}
