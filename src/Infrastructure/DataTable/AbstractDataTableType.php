<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\DataTable;

use Omines\DataTablesBundle\DataTableTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractDataTableType implements DataTableTypeInterface
{
    protected TranslatorInterface $translator;
    protected ContainerInterface $container;
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(
        TranslatorInterface $translator,
        ContainerInterface $container,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->translator = $translator;
        $this->container = $container;
        $this->eventDispatcher = $eventDispatcher;
    }
}
