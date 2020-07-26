<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zentlix\MainBundle\Application\Command\File\UploadCommand;
use Zentlix\MainBundle\Application\Query\File\FileByIdQuery;

class FileController extends AbstractAdminController
{
    public function upload(Request $request): Response
    {
        try {
            $files = $request->files->all();
            $command = new UploadCommand(array_shift($files), $request->request->get('savePath'));
            $this->exec($command);

            return $this->json($this->ask(new FileByIdQuery($command->id)));
        } catch (\Exception $e) {
            return $this->json($this->error($e->getMessage()));
        }
    }
}