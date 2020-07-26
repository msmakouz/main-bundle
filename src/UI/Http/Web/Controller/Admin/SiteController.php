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
    public static $createSuccessMessage = 'zentlix.main.site.create.success';
    public static $updateSuccessMessage = 'zentlix.main.site.update.success';
    public static $deleteSuccessMessage = 'zentlix.main.site.delete.success';
    public static $redirectAfterAction  = 'admin.site.list';

    public function index(Request $request): Response
    {
        return $this->listResource(new DataTableQuery(Table::class), $request);
    }

    public function create(Request $request): Response
    {
        return $this->createResource(new CreateCommand(), CreateForm::class, $request);
    }

    public function update(Site $site, Request $request): Response
    {
        return $this->updateResource(new UpdateCommand($site), UpdateForm::class, $request);
    }

    public function delete(Site $site): Response
    {
        return $this->deleteResource(new DeleteCommand($site));
    }
}