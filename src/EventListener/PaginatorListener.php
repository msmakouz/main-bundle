<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\EventListener;

use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Zentlix\MainBundle\Domain\Marketplace\Service\Applications;

class PaginatorListener
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function __invoke(ItemsEvent $event): void
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
}
