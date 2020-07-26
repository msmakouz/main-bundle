<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Dashboard;

interface WidgetInterface
{
    public function getType(): string;
    public function getData();
    public function getTitle(): string;

    public const TABLE_TYPE = 'table';
}