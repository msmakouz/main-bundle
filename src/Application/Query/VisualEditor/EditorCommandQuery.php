<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\VisualEditor;

use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;

class EditorCommandQuery implements QueryInterface
{
    public function __construct(
        private string $class,
        private string $code
    ) {
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
