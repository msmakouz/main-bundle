<?php

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
            $table = $this->ask($query)->handleRequest($this->requestStack->getCurrentRequest());
            if ($table->isCallback()) {
                return $table->getResponse();
            }

            return $this->render($template, array_merge(['datatable' => $table], $parameters));
        } catch (\Exception $e) {
            return $this->redirectError($e->getMessage());
        }
    }

    public function createResource(
        CommandInterface $command,
        string $formClass,
        string $template,
        array $parameters = []
    ): Response {
        try {
            $form = $this->formFactory->create($formClass, $command);
            $form->handleRequest($this->requestStack->getCurrentRequest());

            if ($form->isSubmitted() && $form->isValid()) {
                $this->exec($command);
                $this->addFlash('success', static::$createSuccessMessage);

                return $this->redirectToRoute(
                    $this->getRedirectRoute(static::$redirectAfterCreate),
                    $this->getRedirectRouteParam(static::$redirectAfterCreate)
                );
            }
        } catch (\Exception $e) {
            return $this->redirectError($e->getMessage());
        }

        return $this->render($template, array_merge(['form' => $form->createView()], $parameters));
    }

    public function updateResource(
        CommandInterface $command,
        string $formClass,
        string $template,
        array $parameters = []
    ): Response {
        $form = $this->formFactory->create($formClass, $command);

        try {
            $form->handleRequest($this->requestStack->getCurrentRequest());
            if ($form->isSubmitted() && $form->isValid()) {
                $this->exec($command);
                $this->addFlash('success', static::$updateSuccessMessage);

                return $this->redirectToRoute(
                    $this->getRedirectRoute(static::$redirectAfterUpdate),
                    $this->getRedirectRouteParam(static::$redirectAfterUpdate)
                );
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
            $this->addFlash('success', static::$deleteSuccessMessage);

            return $this->redirectToRoute(
                $this->getRedirectRoute(static::$redirectAfterDelete),
                $this->getRedirectRouteParam(static::$redirectAfterDelete)
            );
        } catch (\Exception $e) {
            return $this->redirectError($e->getMessage());
        }
    }

    private function getRedirectRoute(array $route = null): string
    {
        if (\is_null($route)) {
            return static::$redirectAfterAction;
        }

        return $route[0];
    }

    private function getRedirectRouteParam(array $route = null): array
    {
        if (\is_null($route)) {
            return [];
        }

        return $route[1];
    }
}
