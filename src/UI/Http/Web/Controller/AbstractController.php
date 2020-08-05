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

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Domain\Site\Entity\Template;
use Zentlix\MainBundle\Domain\Site\Service\Sites;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryBus;

class AbstractController extends BaseController implements AbstractControllerInterface
{
    /** @var Template current template */
    protected Template $template;

    /** @var Site current site */
    protected Site $site;

    protected TranslatorInterface $translator;
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(Sites $sites, TranslatorInterface $translator, CommandBus $commandBus, QueryBus $queryBus)
    {
        $site = $sites->getCurrentSite();

        $this->site = $site;
        $this->template = $this->site->getTemplate();
        $this->translator = $translator;
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function render(string $view, array $parameters = [], Response $response = null): Response
    {
        if(array_key_exists('meta_title', $parameters) === false) {
            $parameters['meta_title'] = '';
        }
        if(array_key_exists('meta_description', $parameters) === false) {
            $parameters['meta_description'] = '';
        }
        if(array_key_exists('meta_keywords', $parameters) === false) {
            $parameters['meta_keywords'] = '';
        }

        if($view[0] !== '@') {
            $view = DIRECTORY_SEPARATOR . $this->template->getFolder() . DIRECTORY_SEPARATOR . $view;
        }

        return parent::render(
            $view,
            array_merge($parameters, [
                'template' => $this->template->getFolder()
            ]),
            $response
        );
    }

    /**
     * @param $command
     * @throws \Exception
     */
    protected function exec($command): void
    {
        $this->commandBus->handle($command);
    }

    /**
     * @param $query
     * @return mixed
     * @throws \Exception
     */
    protected function ask($query)
    {
        return $this->queryBus->handle($query);
    }
}