<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle\Zentlix;

use Symfony\Component\Uid\Uuid;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;
use Zentlix\MainBundle\ZentlixBundleInterface;

class InstallCommand implements CommandInterface
{
    public $id;
    public \DateTimeImmutable $updated_at;
    public \DateTimeImmutable $installed_at;

    public function __construct(
        private ZentlixBundleInterface $bundle
    ) {
        $this->id = Uuid::v4();
        $this->updated_at = new \DateTimeImmutable();
        $this->installed_at = new \DateTimeImmutable();
    }

    public function getBundle(): ZentlixBundleInterface
    {
        return $this->bundle;
    }
}
