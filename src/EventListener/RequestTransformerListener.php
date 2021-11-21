<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestTransformerListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (false === $this->isAvailable($request)) {
            return;
        }

        if (false === $this->transform($request)) {
            $response = Response::create('Unable to parse request.', 400);

            $event->setResponse($response);
        }
    }

    private function isAvailable(Request $request): bool
    {
        return 'json' === $request->getContentType() && $request->getContent();
    }

    private function transform(Request $request): bool
    {
        $data = \json_decode($request->getContent(), true);

        if (\JSON_ERROR_NONE !== json_last_error()) {
            return false;
        }

        if (\is_array($data)) {
            $request->request->replace($data);
        }

        return true;
    }
}
