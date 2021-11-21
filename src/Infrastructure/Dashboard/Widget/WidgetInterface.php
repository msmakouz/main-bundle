<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Dashboard\Widget;

interface WidgetInterface
{
    public function getTemplate(): string;

    public function getTitle(): string;
}
