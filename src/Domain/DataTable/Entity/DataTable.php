<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\DataTable\Entity;

use Doctrine\ORM\Mapping;
use Symfony\Component\Uid\Uuid;
use Zentlix\UserBundle\Domain\User\Entity\User;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\DataTable\Repository\DataTableRepository")
 * @Mapping\Table(name="zentlix_main_datatables")
 */
class DataTable
{
    /**
     * @Mapping\Id
     * @Mapping\Column(type="uuid", unique=true)
     */
    private $id;

    /** @Mapping\Column(type="string", length=255) */
    private $datatable;

    /**
     * @Mapping\ManyToOne(targetEntity="Zentlix\UserBundle\Domain\User\Entity\User")
     * @Mapping\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /** @Mapping\Column(type="json") */
    private $config;

    public function __construct(string $dataTable, array $config, User $user)
    {
        $this->id = Uuid::v4();
        $this->datatable = $dataTable;
        $this->config = $config;
        $this->user = $user;
    }

    public function update(array $config): void
    {
        $this->config = $config;
    }

    public function isVisible(string $field): bool
    {
        return isset($this->config['visible']) &&
            is_array($this->config['visible']) &&
            in_array($field, $this->config['visible'], true);
    }
}
