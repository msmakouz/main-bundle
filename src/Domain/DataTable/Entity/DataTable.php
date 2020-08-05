<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\DataTable\Entity;

use Doctrine\ORM\Mapping;
use Zentlix\UserBundle\Domain\User\Entity\User;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\DataTable\Repository\DataTableRepository")
 * @Mapping\Table(name="zentlix_main_datatables")
 */
class DataTable
{
    /**
     * @Mapping\Id()
     * @Mapping\GeneratedValue()
     * @Mapping\Column(type="integer")
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
        $this->datatable = $dataTable;
        $this->config = $config;
        $this->user = $user;
    }

    public function update(array $config)
    {
        $this->config = $config;
    }

    public function isVisible(string $field): bool
    {
        return isset($this->config['visible']) && is_array($this->config['visible']) && in_array($field, $this->config['visible']);
    }
}