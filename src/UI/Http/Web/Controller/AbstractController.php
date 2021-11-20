<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

abstract class AbstractController implements AbstractControllerInterface
{
    public function __construct(
        protected HttpFoundation\RequestStack $requestStack,
        protected SerializerInterface $serializer,
        protected AuthorizationCheckerInterface $authorizationChecker,
        protected FormFactoryInterface $formFactory,
        protected ParameterBag $parameterBag,
        protected RouterInterface $router,
        protected TranslatorInterface $translator,
        protected Environment $twig,
        protected TokenStorageInterface $tokenStorage
    ) {
    }

    protected function redirect(string $url, int $status = 302): HttpFoundation\RedirectResponse
    {
        return new HttpFoundation\RedirectResponse($url, $status);
    }

    protected function redirectToRoute(
        string $route,
        array $parameters = [],
        int $status = 302
    ): HttpFoundation\RedirectResponse {
        return $this->redirect($this->router->generate($route, $parameters), $status);
    }

    protected function json(
        mixed $data,
        int $status = 200,
        array $headers = [],
        array $context = []
    ): HttpFoundation\JsonResponse {
        $json = $this->serializer->serialize($data, 'json', array_merge([
            'json_encode_options' => HttpFoundation\JsonResponse::DEFAULT_ENCODING_OPTIONS,
        ], $context));

        return new HttpFoundation\JsonResponse($json, $status, $headers, true);
    }

    protected function addFlash(string $type, mixed $message): void
    {
        try {
            $this->requestStack->getSession()->getFlashBag()->add($type, $message);
        } catch (HttpFoundation\Exception\SessionNotFoundException $e) {
            throw new \LogicException('You cannot use the addFlash method if sessions are disabled.', 0, $e);
        }
    }

    protected function renderView(string $view, array $parameters = []): string
    {
        return $this->twig->render($view, $parameters);
    }

    protected function render(
        string $view,
        array $parameters = [],
        HttpFoundation\Response $response = null
    ): HttpFoundation\Response {
        $content = $this->renderView($view, $parameters);

        if (null === $response) {
            $response = new HttpFoundation\Response();
        }

        $response->setContent($content);

        return $response;
    }

    protected function getUser(): ?UserInterface
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        return $token->getUser();
    }
}
