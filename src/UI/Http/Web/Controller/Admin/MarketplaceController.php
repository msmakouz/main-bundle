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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zentlix\MainBundle\Application\Query\Marketplace\GetApplicationsQuery;

class MarketplaceController extends AbstractAdminController
{
    public function applications(Request $request): Response
    {
        try {
            $applications = $this->ask(new GetApplicationsQuery($request->query->getInt('page', 1)));
        } catch (\Exception $exception) {
            return $this->redirectError($exception->getMessage());
        }

        return $this->render('@MainBundle/admin/marketplace/applications.html.twig', [
            'applications' => $applications
        ]);
    }
}