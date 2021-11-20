<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Zentlix\MainBundle\Application\Command\Template\UpdateCommand;
use Zentlix\MainBundle\Application\Query\Template\DataTableQuery;
use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\UI\Http\Web\DataTable\Template\Table;
use Zentlix\MainBundle\UI\Http\Web\Form\Template\UpdateForm;

class TemplateController extends ResourceController
{
    public static $updateSuccessMessage = 'zentlix_main.template.update.success';
    public static $redirectAfterAction  = 'admin.template.list';

    public function index(): Response
    {
        return $this->listResource(new DataTableQuery(Table::class),'@MainBundle/admin/templates/templates.html.twig');
    }

    public function update(Template $template): Response
    {
        $command = new UpdateCommand($template);

        return $this->updateResource($command,UpdateForm::class,'@MainBundle/admin/templates/update.html.twig', ['template' => $template]);
    }
}
