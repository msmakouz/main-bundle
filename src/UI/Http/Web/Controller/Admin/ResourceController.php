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
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;

class ResourceController extends AbstractAdminController
{
    protected static $redirectListError = 'admin.index';
    protected static $redirectAfterCreate;
    protected static $redirectAfterUpdate;
    protected static $redirectAfterDelete;
    protected static $createSuccessMessage;
    protected static $updateSuccessMessage;
    protected static $deleteSuccessMessage;
    protected static $redirectAfterAction = 'admin.index';

    public function listResource(QueryInterface $query, Request $request): Response
    {
        try {
            $table = $this->ask($query);
            return $table->handleRequest($request)->getResponse();
        } catch (\Exception $e) {
            return $this->json($this->redirectError($this->generateUrl(static::$redirectListError), $e->getMessage()));
        }
    }

    public function createResource(CommandInterface $command, string $formClass, Request $request): Response
    {
        try {
            $form = $this->createForm($formClass, $command);

            $this->handleRequest($request, $form);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->exec($command);
                return $this->json($this->redirectSuccess($this->generateRedirectRoute(static::$redirectAfterCreate), $this->translator->trans(static::$createSuccessMessage)));
            }
        } catch (\Exception $e) {
            return $this->json($this->error($e->getMessage()));
        }

        return $this->json($this->liform->transform($form));
    }

    public function updateResource(CommandInterface $command, string $formClass, Request $request): Response
    {
        $form = $this->createForm($formClass, $command);

        try {
            $this->handleRequest($request, $form);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->exec($command);
                return $this->json($this->redirectSuccess($this->generateRedirectRoute(static::$redirectAfterUpdate), $this->translator->trans(static::$updateSuccessMessage)));
            }
        } catch (\Exception $e) {
            return $this->json($this->error($e->getMessage()));
        }

        return $this->json($this->liform->transform($form));
    }

    public function deleteResource(CommandInterface $command): Response
    {
        try {
            $this->exec($command);
            return $this->json($this->redirectSuccess($this->generateRedirectRoute(static::$redirectAfterDelete), $this->translator->trans(static::$deleteSuccessMessage)));
        } catch (\Exception $e) {
            return $this->json($this->error($e->getMessage()));
        }
    }

    private function generateRedirectRoute(array $route = null)
    {
        if(is_array($route)) {
            return $this->generateUrl($route[0], $route[1]);
        }

        return $this->generateUrl(static::$redirectAfterAction);
    }
}