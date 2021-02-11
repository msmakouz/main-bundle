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

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryBus;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;
use Zentlix\MainBundle\UI\Http\Web\Controller\AbstractControllerInterface;

class AbstractAdminController extends BaseController implements AbstractControllerInterface
{
    public static $redirectErrorPath = 'admin.index';

    private Bundles $bundles;
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(Bundles $bundles,
                                CommandBus $commandBus,
                                QueryBus $queryBus)
    {
        $this->bundles = $bundles;
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @throws Throwable
     */
    protected function exec(CommandInterface $command): void
    {
        $this->checkAccess($command);

        $this->commandBus->handle($command);
    }

    /**
     * @throws Throwable
     */
    protected function ask(QueryInterface $query)
    {
        $this->checkAccess($query);

        return $this->queryBus->handle($query);
    }

    protected function redirectSuccess(string $url, string $message): array
    {
        return ['redirect' => $url, 'success' => true, 'message' => $message];
    }

    protected function redirectError(string $message): Response
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

    protected function jsonError(string $message): JsonResponse
    {
        return $this->json(['success' => false, 'message' => $message]);
    }

    private function checkAccess($command)
    {
        if(!$this->bundles->isBundle(get_class($command))) {
            return;
        }

        $rights = $this->bundles->getBundleByNamespace(get_class($command))->configureRights();

        if(isset($rights[get_class($command)]) && !$this->getUser()->isAccessGranted(get_class($command))) {
            throw new \Exception('zentlix_main.access_denied');
        }
    }
}