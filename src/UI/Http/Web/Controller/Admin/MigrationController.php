<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Zentlix\MainBundle\Application\Command\Bundle\Migration\MigrationCommand;

class MigrationController extends AbstractAdminController
{
    public function run(): JsonResponse
    {
        try {
            $this->exec(new MigrationCommand());
        } catch (\Exception $exception) {
            return $this->jsonError($exception->getMessage());
        }

        return $this->json(['success' => true]);
    }
}
