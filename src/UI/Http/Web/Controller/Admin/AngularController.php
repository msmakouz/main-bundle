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
use Zentlix\MainBundle\Application\Query\State;
use Zentlix\MainBundle\Application\Query\Route;

class AngularController extends AbstractAdminController
{
    public function resolve(): Response
    {
        return $this->render('@MainBundle/admin/index.html.twig');
    }

    public function state(): Response
    {
        try {
            return $this->json($this->ask(new State\BuildQuery()));
        } catch (\Exception $e) {
            return $this->json($this->error($e->getMessage()));
        }
    }

    public function routes(): Response
    {
        try {
            return $this->json($this->ask(new Route\BuildQuery()));
        } catch (\Exception $e) {
            return $this->json($this->error($e->getMessage()));
        }
    }
}