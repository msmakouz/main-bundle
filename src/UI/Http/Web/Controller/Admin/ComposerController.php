<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Zentlix\MainBundle\Application\Command\Bundle\Composer\RemoveCommand;
use Zentlix\MainBundle\Application\Command\Bundle\Composer\RequireCommand;

class ComposerController extends AbstractAdminController
{
    public function remove(Request $request): JsonResponse
    {
        try {
            $this->exec(new RemoveCommand($request->get('package')));
        } catch (\Exception $exception) {
            return $this->jsonError($exception->getMessage());
        }

        return $this->json(['success' => true]);
    }

    public function require(Request $request): JsonResponse
    {
        try {
            $this->exec(new RequireCommand($request->get('package')));
        } catch (\Exception $exception) {
            return $this->jsonError($exception->getMessage());
        }

        return $this->json(['success' => true]);
    }
}
