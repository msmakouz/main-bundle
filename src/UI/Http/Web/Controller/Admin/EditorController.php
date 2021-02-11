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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Application\Command\VisualEditor\DisableCommand;
use Zentlix\MainBundle\Application\Command\VisualEditor\EnableCommand;
use Zentlix\MainBundle\Application\Query\VisualEditor\EditorCommandQuery;
use Zentlix\MainBundle\UI\Http\Web\Form\VisualEditorFormInterface;

class EditorController extends AbstractAdminController
{
    public function enable(): JsonResponse
    {
        try {
            $this->exec(new EnableCommand());

            return $this->json(['success' => true]);
        } catch (\Exception $exception) {
            return $this->json(['success' => false, 'error' => $exception->getMessage()]);
        }
    }

    public function disable(): JsonResponse
    {
        try {
            $this->exec(new DisableCommand());

            return $this->json(['success' => true]);
        } catch (\Exception $exception) {
            return $this->json(['success' => false, 'error' => $exception->getMessage()]);
        }
    }

    public function fastEdit(Request $request): JsonResponse
    {
        try {
            $command = $this->ask(new EditorCommandQuery($request->request->get('entity'), $request->request->get('code')));
            $command->update($request->request->get('content'));
            $this->exec($command);

            return $this->json(['success' => true]);
        } catch (\Exception $exception) {
            return $this->json(['success' => false, 'error' => $exception->getMessage()]);
        }
    }

    public function visualEdit(Request $request, TranslatorInterface $translator): JsonResponse
    {
        try {
            $form = $this->createVisualEditorForm(
                $request->request->get('form'),
                $request->request->get('entity'),
                $request->request->get('code'),
                $translator
            );

            if(isset($request->request->get('visual_edit_form')['_token'])) {
                $form['form']->submit($request->request->get('visual_edit_form'));
            }

            if ($form['form']->isSubmitted() && $form['form']->isValid()) {
                $this->exec($form['form']->getData());
                return $this->json(['success' => true, 'content' => $form['form']->getData()->getVisualEditedContent()]);
            }

            return $this->json([
                'success' => true,
                'form' => $this->renderView('@MainBundle/editor/form.html.twig', ['form' => $form['form']->createView()]),
                'title' => $form['title']
            ]);
        } catch (\Exception $exception) {
            return $this->json(['success' => false, 'error' => $exception->getMessage()]);
        }
    }

    private function createVisualEditorForm(string $formClass, string $entityClass, string $code, TranslatorInterface $translator): array
    {
        if(!class_exists($formClass)) {
            throw new \Exception(sprintf('Класс %s не найден.', $formClass));
        }
        $reflection = new \ReflectionClass($formClass);
        if(!$reflection->implementsInterface(VisualEditorFormInterface::class)) {
            throw new \Exception(sprintf('Класс %s должен имплементировать VisualEditorFormInterface.', $formClass));
        }
        $command = $this->ask(new EditorCommandQuery($entityClass, $code));

        $form['form'] = $this->createForm($formClass, $command);

        $translationDomain = $form['form']->getConfig()->getOption('translation_domain');
        if ($label = $form['form']->getConfig()->getOption('label')) {
            $form['title'] = $translator->trans($label, [], $translationDomain);
        } else {
            $form['title'] = $translator->trans($form['form']->getName(), [], $translationDomain);
        }

        return $form;
    }
}