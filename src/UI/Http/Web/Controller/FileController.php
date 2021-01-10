<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zentlix\MainBundle\Application\Command\File\UploadCommand;
use Zentlix\MainBundle\Application\Query\File\GetFileByIdQuery;

class FileController extends AbstractController
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