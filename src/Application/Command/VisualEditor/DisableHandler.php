<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\VisualEditor;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\VisualEditor\Event\AfterDisable;
use Zentlix\MainBundle\Domain\VisualEditor\Event\BeforeDisable;
use Zentlix\MainBundle\Domain\VisualEditor\Service\VisualEditor;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class DisableHandler implements CommandHandlerInterface
{
    public function __construct(
        private VisualEditor $visualEditor,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function __invoke(DisableCommand $command): void
    {
        $this->eventDispatcher->dispatch(new BeforeDisable());

        $this->visualEditor->disable();

        $this->eventDispatcher->dispatch(new AfterDisable());
    }
}
