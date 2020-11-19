<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle\Zentlix;

use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;
use Zentlix\MainBundle\ZentlixBundleInterface;

class InstallCommand implements CommandInterface
{
    public \DateTimeImmutable $updated_at;
    public \DateTimeImmutable $installed_at;
    private ZentlixBundleInterface $bundle;

    public function __construct(ZentlixBundleInterface $bundle)
    {
        $this->updated_at = new \DateTimeImmutable();
        $this->installed_at = new \DateTimeImmutable();
        $this->bundle = $bundle;
    }

    public function getBundle(): ZentlixBundleInterface
    {
        return $this->bundle;
    }
}