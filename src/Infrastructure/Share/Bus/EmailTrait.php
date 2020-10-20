<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Share\Bus;

use Zentlix\UserBundle\Domain\User\ValueObject\Email;

trait EmailTrait {

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getEmailObject(): ?Email
    {
        if(is_null($this->email) === false) {
            return new Email($this->email);
        }

        return null;
    }
}