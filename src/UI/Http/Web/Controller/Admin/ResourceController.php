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

use Symfony\Component\HttpFoundation\Response;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;

class ResourceController extends AbstractAdminController
{
    protected static $redirectAfterCreate;
    protected static $redirectAfterUpdate;
    protected static $redirectAfterDelete;
    protected static $createSuccessMessage;
    protected static $updateSuccessMessage;
    protected static $deleteSuccessMessage;
    protected static $redirectAfterAction = 'admin.index';

    public function listResource(QueryInterface $query, string $template, array $parameters = []): Response
    {
        try {
            $table = $this->ask($query)->handleRequest($this->container->get('request_stack')->getCurrentRequest());
            if ($table->isCallback()) {
                return $table->getResponse();
            }

            return $this->render($template, array_merge(['datatable' => $table], $parameters));
        } catch (\Exception $e) {
            return $this->redirectError($e->getMessage());
        }
    }

    public function createResource(CommandInterface $command, string $formClass, string $template, array $parameters = []): Response
    {
        try {
            $form = $this->createForm($formClass, $command);
            $form->handleRequest($this->container->get('request_stack')->getCurrentRequest());

            if ($form->isSubmitted() && $form->isValid()) {
                $this->exec($command);
                $this->addFlash('success', $this->translator->trans(static::$createSuccessMessage));
                return $this->redirectToRoute($this->getRedirectRoute(static::$redirectAfterCreate));
            }
        } catch (\Exception $e) {
            return $this->redirectError($e->getMessage());
        }

        return $this->render($template, array_merge(['form' => $form->createView()], $parameters));
    }

    public function updateResource(CommandInterface $command, string $formClass, string $template, array $parameters = []): Response
    {
        $form = $this->createForm($formClass, $command);

        try {
            $form->handleRequest($this->container->get('request_stack')->getCurrentRequest());
            if ($form->isSubmitted() && $form->isValid()) {
                $this->exec($command);
                $this->addFlash('success', $this->translator->trans(static::$updateSuccessMessage));
                return $this->redirectToRoute($this->getRedirectRoute(static::$redirectAfterUpdate));
            }
        } catch (\Exception $e) {
            return $this->redirectError($e->getMessage());
        }

        return $this->render($template, array_merge(['form' => $form->createView()], $parameters));
    }

    public function deleteResource(CommandInterface $command): Response
    {
        try {
            $this->exec($command);
            $this->addFlash('success', $this->translator->trans(static::$deleteSuccessMessage));
            return $this->redirectToRoute($this->getRedirectRoute(static::$redirectAfterDelete));
        } catch (\Exception $e) {
            return $this->redirectError($e->getMessage());
        }
    }

    private function getRedirectRoute(array $route = null)
    {
       if(is_null($route)) {
           return static::$redirectAfterAction;
       }

        return $route;
    }
}