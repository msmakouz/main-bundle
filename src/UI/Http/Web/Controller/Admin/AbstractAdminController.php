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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Limenius\Liform\Resolver;
use Limenius\Liform\Liform;
use Throwable;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandBus;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryBus;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;
use Zentlix\MainBundle\UI\Http\Web\Controller\AbstractControllerInterface;
use Zentlix\MainBundle\UI\Http\Web\JsonTransformer;

class AbstractAdminController extends BaseController implements AbstractControllerInterface
{
    protected TranslatorInterface $translator;
    protected Liform $liform;
    private CsrfTokenManagerInterface $tokenManager;
    private Bundles $bundles;
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(TranslatorInterface $translator,
                                CsrfTokenManagerInterface $tokenManager,
                                Bundles $bundles,
                                CommandBus $commandBus,
                                QueryBus $queryBus)
    {
        $this->translator = $translator;
        $this->tokenManager = $tokenManager;
        $this->liform = new Liform($this->configureLiform());
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

        return $this->redirectToRoute('admin.index');
    }

    protected function error(string $message): array
    {
        return ['success' => false, 'message' => $message];
    }

    private function configureLiform() :Resolver
    {
        $resolver = new Resolver();
        $resolver->setTransformer('email', new JsonTransformer\StringTransformer($this->translator), 'email');
        $resolver->setTransformer('phone_number', new JsonTransformer\StringTransformer($this->translator), 'tel');
        $resolver->setTransformer('password', new JsonTransformer\StringTransformer($this->translator), 'password');
        $resolver->setTransformer('editor', new JsonTransformer\EditorTransformer($this->translator));
        $resolver->setTransformer('file', new JsonTransformer\FileTransformer($this->translator));
        $resolver->setTransformer('data', new JsonTransformer\DataTransformer($this->translator));
        $resolver->setTransformer('choice', new JsonTransformer\ChoiceTransformer($this->translator));
        $resolver->setTransformer('text', new JsonTransformer\StringTransformer($this->translator));
        $resolver->setTransformer('textarea', new JsonTransformer\TextareaTransformer($this->translator));
        $resolver->setTransformer('hidden', new JsonTransformer\HiddenTransformer($this->translator));
        $resolver->setTransformer('number', new JsonTransformer\NumberTransformer($this->translator));
        $resolver->setTransformer('integer', new JsonTransformer\IntegerTransformer($this->translator));
        $resolver->setTransformer('compound', new JsonTransformer\CompoundTransformer($this->translator, $resolver, $this->tokenManager, null));
        $resolver->setTransformer('checkbox', new JsonTransformer\BooleanTransformer($this->translator));
        $resolver->setTransformer('datatable', new JsonTransformer\DataTableTransformer($this->translator));

        return $resolver;
    }

    private function checkAccess($command)
    {
        if(!$this->bundles->isBundle(get_class($command))) {
            return;
        }

        $rights = $this->bundles->getBundleByNamespace(get_class($command))->configureRights();

        if(isset($rights[get_class($command)]) && !$this->getUser()->isAccessGranted(get_class($command))) {
            throw new \Exception($this->translator->trans('zentlix_main.access_denied'));
        }
    }
}