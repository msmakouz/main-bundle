<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zentlix\MainBundle\Application\Command\File\UploadCommand;
use Zentlix\MainBundle\Application\Query\File\GetFileByIdQuery;

class FileController extends AbstractAdminController
{
    public function upload(Request $request): Response
    {
        try {
            $files = $request->files->all();
            $command = new UploadCommand(array_shift($files), $request->request->get('savePath') ?? '');
            $this->exec($command);

            return $this->json($this->ask(new GetFileByIdQuery($command->id)));
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage());
        }
    }
}
