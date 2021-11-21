<?php

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
            'applications' => $applications,
        ]);
    }
}
