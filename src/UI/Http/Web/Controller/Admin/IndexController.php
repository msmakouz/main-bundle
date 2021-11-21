<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractAdminController
{
    public function index(): Response
    {
        return $this->render('@MainBundle/admin/index.html.twig');
    }
}
