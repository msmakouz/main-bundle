<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\VisualEditor;

use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;

class EditorCommandQuery implements QueryInterface
{
    private string $class;
    private string $code;

    public function __construct(string $class, string $code)
    {
        $this->class = $class;
        $this->code = $code;
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