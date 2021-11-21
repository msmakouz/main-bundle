<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Share\Bus;

use Zentlix\UserBundle\Domain\User\ValueObject\Email;

trait EmailTrait
{
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getEmailObject(): ?Email
    {
        if (false === is_null($this->email)) {
            return new Email($this->email);
        }

        return null;
    }
}
