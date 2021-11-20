<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller\Admin;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Throwable;
use Twig\Environment;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus;
use Zentlix\MainBundle\UI\Http\Web\Controller\AbstractController;

abstract class AbstractAdminController extends AbstractController
{
    public static $redirectErrorPath = 'admin.index';

    public function __construct(
        protected HttpFoundation\RequestStack $requestStack,
        protected SerializerInterface $serializer,
        protected AuthorizationCheckerInterface $authorizationChecker,
        protected FormFactoryInterface $formFactory,
        protected ParameterBag $parameterBag,
        protected RouterInterface $router,
        protected TranslatorInterface $translator,
        protected Environment $twig,
        protected TokenStorageInterface $tokenStorage,
        private Bus\CommandBus $commandBus,
        private Bus\QueryBus $queryBus,
        private Bundles $bundles
    ) {
        parent::__construct(
            $this->requestStack,
            $this->serializer,
            $this->authorizationChecker,
            $this->formFactory,
            $this->parameterBag,
            $this->router,
            $this->translator,
            $this->twig,
            $this->tokenStorage
        );
    }

    /** @throws Throwable */
    protected function exec(Bus\CommandInterface $command): void
    {
        $this->checkAccess($command);

        $this->commandBus->handle($command);
    }

    /** @throws Throwable */
    protected function ask(Bus\QueryInterface $query): mixed
    {
        $this->checkAccess($query);

        return $this->queryBus->handle($query);
    }

    protected function redirectSuccess(string $url, string $message): array
    {
        return ['redirect' => $url, 'success' => true, 'message' => $message];
    }

    protected function redirectError(string $message): HttpFoundation\Response
    {
        $this->addFlash('error', $message);

        $route = static::$redirectErrorPath;
        $parameters = [];
        if(is_array(static::$redirectErrorPath)) {
            $route = static::$redirectErrorPath[0];
            $parameters = static::$redirectErrorPath[1];
        }

        return $this->redirectToRoute($route, $parameters);
    }

    protected function jsonError(string $message): HttpFoundation\JsonResponse
    {
        return $this->json(['success' => false, 'message' => $message]);
    }

    private function checkAccess(Bus\CommandInterface|Bus\QueryInterface $command)
    {
        if(!$this->bundles->isBundle($command::class)) {
            return;
        }

        $rights = $this->bundles->getBundleByNamespace($command::class)->configureRights();

        if(isset($rights[$command::class]) && !$this->getUser()->isAccessGranted($command::class)) {
            throw new \Exception('zentlix_main.access_denied');
        }
    }
}
