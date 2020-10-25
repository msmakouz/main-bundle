<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\DataTable;

use Omines\DataTablesBundle\DataTableTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractDataTableType implements DataTableTypeInterface {

    protected TranslatorInterface $translator;
    protected ContainerInterface $container;
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(TranslatorInterface $translator,
                                ContainerInterface $container,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->translator = $translator;
        $this->container = $container;
        $this->eventDispatcher = $eventDispatcher;
    }
}