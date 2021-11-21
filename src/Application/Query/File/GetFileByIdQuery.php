<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\File;

use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;

class GetFileByIdQuery implements QueryInterface
{
    public function __construct(
        public $id
    ) {
    }
}
