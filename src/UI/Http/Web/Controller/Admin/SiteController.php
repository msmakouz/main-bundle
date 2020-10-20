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
use Zentlix\MainBundle\Application\Command\Site\CreateCommand;
use Zentlix\MainBundle\Application\Command\Site\UpdateCommand;
use Zentlix\MainBundle\Application\Command\Site\DeleteCommand;
use Zentlix\MainBundle\Application\Query\Site\DataTableQuery;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\UI\Http\Web\DataTable\Site\Table;
use Zentlix\MainBundle\UI\Http\Web\Form\Site\CreateForm;
use Zentlix\MainBundle\UI\Http\Web\Form\Site\UpdateForm;

class SiteController extends ResourceController
{
    public static $createSuccessMessage = 'zentlix_main.site.create.success';
    public static $updateSuccessMessage = 'zentlix_main.site.update.success';
    public static $deleteSuccessMessage = 'zentlix_main.site.delete.success';
    public static $redirectAfterAction  = 'admin.site.list';

    public function index(): Response
    {
        return $this->listResource(new DataTableQuery(Table::class),'@MainBundle/admin/sites/sites.html.twig');
    }

    public function create(): Response
    {
        return $this->createResource(new CreateCommand(), CreateForm::class,'@MainBundle/admin/sites/create.html.twig');
    }

    public function update(Site $site): Response
    {
        return $this->updateResource(
            new UpdateCommand($site),UpdateForm::class,'@MainBundle/admin/sites/update.html.twig', ['site' => $site]
        );
    }

    public function delete(Site $site): Response
    {
        return $this->deleteResource(new DeleteCommand($site));
    }
}