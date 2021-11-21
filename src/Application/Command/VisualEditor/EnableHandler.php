<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\VisualEditor;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Domain\VisualEditor\Event\AfterEnable;
use Zentlix\MainBundle\Domain\VisualEditor\Event\BeforeEnable;
use Zentlix\MainBundle\Domain\VisualEditor\Service\VisualEditor;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class EnableHandler implements CommandHandlerInterface
{
    public function __construct(
        private VisualEditor $visualEditor,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function __invoke(EnableCommand $command): void
    {
        $this->eventDispatcher->dispatch(new BeforeEnable());

        $this->visualEditor->enable();

        $this->eventDispatcher->dispatch(new AfterEnable());
    }
}
