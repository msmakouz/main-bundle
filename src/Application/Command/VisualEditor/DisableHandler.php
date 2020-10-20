<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\VisualEditor;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\VisualEditor\Event\AfterDisable;
use Zentlix\MainBundle\Domain\VisualEditor\Event\BeforeDisable;
use Zentlix\MainBundle\Domain\VisualEditor\Service\VisualEditor;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class DisableHandler implements CommandHandlerInterface
{
    private VisualEditor $visualEditor;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(VisualEditor $editor, EventDispatcherInterface $eventDispatcher)
    {
        $this->visualEditor = $editor;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(DisableCommand $command): void
    {
        $this->eventDispatcher->dispatch(new BeforeDisable());

        $this->visualEditor->disable();

        $this->eventDispatcher->dispatch(new AfterDisable());
    }
}