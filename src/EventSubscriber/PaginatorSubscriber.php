<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\Event\ItemsEvent;
use Zentlix\MainBundle\Application\Command;
use Zentlix\MainBundle\Domain\Marketplace\Service\Applications;

class PaginatorSubscriber implements EventSubscriberInterface
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getItems(ItemsEvent $event)
    {
        if ($event->target instanceof Applications) {
            $request = $this->requestStack->getCurrentRequest();

            $data = $event->target->getItems(
                $event->getOffset() / $event->getLimit() + 1,
                $event->getLimit(),
                $request ? $request->get('sort') : null,
                $request ? (int) $request->get('category') : null
            );

            $event->count = $data['meta']['total'];
            $event->items = $data['data'];

            $event->stopPropagation();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.items' => ['getItems', 1]
        ];
    }
}