<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zentlix\MainBundle\Application\Command\Bundle\Zentlix\InstallCommand;
use Zentlix\MainBundle\Application\Command\Bundle\Zentlix\RemoveCommand;
use Zentlix\MainBundle\Application\Command\Setting\DefaultSettingCommand;
use Zentlix\MainBundle\Application\Query\Bundle\DataTableQuery;
use Zentlix\MainBundle\Application\Query\Bundle\GetNotInstalledBundlesQuery;
use Zentlix\MainBundle\Application\Query\Bundle\GetBundleEntityByPackageNameQuery;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\UI\Http\Web\DataTable\Bundle\Table;
use Zentlix\MainBundle\UI\Http\Web\Form\Setting\DefaultForm;

class BundleController extends ResourceController
{
    static $updateSuccessMessage = 'zentlix_main.bundle.update.success';
    static $redirectAfterAction = 'admin.bundle.list';

    public function index(): Response
    {
       return $this->listResource(new DataTableQuery(Table::class),'@MainBundle/admin/bundles/bundles.html.twig');
    }

    public function changeSettings(Bundle $bundle, EntityManagerInterface $entityManager): Response
    {
        if($bundle->getSettingsEntity() && $bundle->getSettingsForm()) {
            $settingRepository = $entityManager->getRepository($bundle->getSettingsEntity());
            $command = $this->formFactory->create($bundle->getSettingsForm())->getConfig()->getDataClass();

            return $this->updateResource(
                new $command($settingRepository->findOneBy([])),
                $bundle->getSettingsForm(), '@MainBundle/admin/bundles/settings.html.twig'
            );
        }

        return $this->updateResource(
            new DefaultSettingCommand(),
            DefaultForm::class,
            '@MainBundle/admin/bundles/default.html.twig'
        );
    }

    public function install(Request $request): Response
    {
        try {
            foreach ($this->ask(new GetNotInstalledBundlesQuery($request->get('package'))) as $app) {
                $this->exec(new InstallCommand($app));
            }
        } catch (\Exception $exception) {
            return $this->jsonError($exception->getMessage());
        }

        return $this->json(['success' => true]);
    }

    public function remove(Request $request): Response
    {
        try {
            $this->exec(new RemoveCommand($this->ask(new GetBundleEntityByPackageNameQuery($request->get('package')))));
        } catch (\Exception $exception) {
            return $this->jsonError($exception->getMessage());
        }

        return $this->json(['success' => true]);
    }
}
