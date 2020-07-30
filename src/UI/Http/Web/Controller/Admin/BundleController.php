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

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zentlix\MainBundle\Application\Command\Setting\DefaultSettingCommand;
use Zentlix\MainBundle\Application\Query\Bundle\DataTableQuery;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\UI\Http\Web\DataTable\Bundle\Table;
use Zentlix\MainBundle\UI\Http\Web\Form\Setting\DefaultForm;

class BundleController extends ResourceController
{
    static $updateSuccessMessage = 'zentlix_main.bundle.update.success';

    public function index(Request $request): Response
    {
       return $this->listResource(new DataTableQuery(Table::class), $request);
    }

    public function changeSettings(Bundle $bundle, EntityManagerInterface $entityManager, Request $request): Response
    {
        if($bundle->getSettingsEntity() && $bundle->getSettingsForm()) {
            $settingRepository = $entityManager->getRepository($bundle->getSettingsEntity());
            $command = $this->createForm($bundle->getSettingsForm())->getConfig()->getDataClass();

            return $this->updateResource(new $command($settingRepository->findOneBy([])), $bundle->getSettingsForm(), $request);
        }

        return $this->updateResource(new DefaultSettingCommand(), DefaultForm::class, $request);
    }
}