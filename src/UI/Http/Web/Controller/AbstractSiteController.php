<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Domain\Site\Service\Sites;
use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\Infrastructure\Share\Bus;

abstract class AbstractSiteController extends AbstractController
{
    /** @var Template current template */
    protected Template $template;

    /** @var Site current site */
    protected Site $site;

    public function __construct(
        Sites $sites,
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
        private Bus\QueryBus $queryBus
    ) {
        $site = $sites->getCurrentSite();

        $this->site = $site;
        $this->template = $this->site->getTemplate();

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

    public function render(
        string $view,
        array $parameters = [],
        HttpFoundation\Response $response = null
    ): HttpFoundation\Response {
        $parameters['meta_title'] ??= '';
        $parameters['meta_description'] ??= '';
        $parameters['meta_keywords'] ??= '';

        if ('@' !== $view[0]) {
            $view = DIRECTORY_SEPARATOR . $this->template->getFolder() . DIRECTORY_SEPARATOR . $view;
        }

        return parent::render(
            $view,
            array_merge($parameters, ['template' => $this->template->getFolder()]),
            $response
        );
    }

    protected function exec(Bus\CommandInterface $command): void
    {
        $this->commandBus->handle($command);
    }

    protected function ask(Bus\QueryInterface $query)
    {
        return $this->queryBus->handle($query);
    }
}
