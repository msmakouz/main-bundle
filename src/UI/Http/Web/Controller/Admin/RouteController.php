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
use Symfony\Component\HttpFoundation\Request;
use Zentlix\MainBundle\Application\Command\Route\UpdateCommand;
use Zentlix\MainBundle\Domain\Site\Repository\SiteRepository;
use Zentlix\MainBundle\UI\Http\Web\Form\Route\UpdateForm;

class RouteController extends ResourceController
{
    public static $updateSuccessMessage = 'zentlix_main.route.update.success';

    public function update(Request $request, SiteRepository $siteRepository): Response
    {
        $request->request->get('site') ? $site = $siteRepository->find((int) $request->request->get('site')) :
            $site = $siteRepository->findOneBy([], ['sort' => 'ASC']);

        return $this->updateResource(new UpdateCommand($site->getRoutes()->getValues(), $site->getId()), UpdateForm::class, $request);
    }
}
