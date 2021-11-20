<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zentlix\MainBundle\Application\Command\File\UploadCommand;
use Zentlix\MainBundle\Application\Query\File\GetFileByIdQuery;

class FileController extends AbstractSiteController
{
    public function upload(Request $request): Response
    {
        try {
            $files = $request->files->all();
            $command = new UploadCommand(array_shift($files));
            $this->exec($command);

            $file = $this->ask(new GetFileByIdQuery($command->id));

            return $this->json(['url' => $file['url']]);
        } catch (\Exception $e) {
            return $this->json([
                'error' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }
}
