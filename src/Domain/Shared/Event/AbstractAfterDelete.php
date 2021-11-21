<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Event;

class AbstractAfterDelete
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
