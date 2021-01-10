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
use Zentlix\MainBundle\Application\Command\Attribute\CreateCommand;
use Zentlix\MainBundle\Application\Command\Attribute\DeleteCommand;
use Zentlix\MainBundle\Application\Command\Attribute\UpdateCommand;
use Zentlix\MainBundle\Application\Query\Attribute\GetEntitiesQuery;
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;

class AttributeController extends ResourceController
{
    public static $createSuccessMessage = 'zentlix_main.attribute.create.success';
    public static $updateSuccessMessage = 'zentlix_main.attribute.update.success';
    public static $deleteSuccessMessage = 'zentlix_main.attribute.delete.success';

    public function index(string $entity = null): Response
    {
        $entities = array_map(fn(string $class) => [
            'code'  => $class::getEntityCode(),
            'title' => $class::getEntityTitle()
        ], $this->ask(new GetEntitiesQuery()));

        return $this->render('@MainBundle/admin/attributes/index.html.twig', [
            'entities' => $entities,
            'entity'   => $entity
        ]);
    }

    public function create(string $entity, Request $request): Response
    {
        $form = (string) $request->request->get('create_form')['form'];

        static::$redirectAfterCreate = ['admin.attribute.manage', ['entity' => $entity]];

        return $this->createResource(new CreateCommand($entity), $form, '');
    }

    public function update(Attribute $attribute, Request $request): Response
    {
        $form = (string) $request->request->get('update_form')['form'];

        static::$redirectAfterUpdate = ['admin.attribute.manage', ['entity' => $attribute->getEntity()]];

        return $this->updateResource(new UpdateCommand($attribute), $form, '');
    }

    public function delete(Attribute $attribute)
    {
        static::$redirectAfterDelete = ['admin.attribute.manage', ['entity' => $attribute->getEntity()]];

        return $this->deleteResource(new DeleteCommand($attribute));
    }
}