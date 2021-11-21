<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Share\Bus;

interface VisualEditorCommandInterface
{
    public function update(string $content = null): void;

    public function getVisualEditedContent(): ?string;
}
