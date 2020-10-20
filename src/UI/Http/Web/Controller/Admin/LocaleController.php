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
use Zentlix\MainBundle\Application\Command\Locale\UpdateCommand;
use Zentlix\MainBundle\Application\Query\Locale\DataTableQuery;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\UI\Http\Web\DataTable\Locale\Table;
use Zentlix\MainBundle\UI\Http\Web\Form\Locale\UpdateForm;

class LocaleController extends ResourceController
{
    public static $updateSuccessMessage = 'zentlix_main.locale.update.success';
    public static $redirectAfterAction  = 'admin.locale.list';

    public function index(): Response
    {
        return $this->listResource(new DataTableQuery(Table::class), '@MainBundle/admin/locales/locales.html.twig');
    }

    public function update(Locale $locale): Response
    {
        return $this->updateResource(new UpdateCommand($locale), UpdateForm::class,'@MainBundle/admin/locales/update.html.twig');
    }
}
