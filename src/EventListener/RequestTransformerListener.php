<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use function is_array;
use function json_decode;

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
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== \JSON_ERROR_NONE) {
            return false;
        }

        if (is_array($data)) {
            $request->request->replace($data);
        }

        return true;
    }
}