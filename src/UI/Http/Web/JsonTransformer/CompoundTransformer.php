<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\JsonTransformer;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Limenius\Liform\ResolverInterface;

class CompoundTransformer extends AbstractTransformer
{
    protected ResolverInterface $resolver;
    private CsrfTokenManagerInterface $tokenManager;

    public function __construct(
        TranslatorInterface $translator,
        ResolverInterface $resolver,
        CsrfTokenManagerInterface $tokenManager,
        FormTypeGuesserInterface $validatorGuesser = null
    ) {
        parent::__construct($translator, $validatorGuesser);
        $this->resolver = $resolver;
        $this->tokenManager = $tokenManager;
    }

    public function transform(FormInterface $form, array $extensions = [], $widget = null)
    {
        $data = [];
        $required = [];

        foreach ($form->all() as $name => $field) {
            $transformerData = $this->resolver->resolve($field);
            $transformedChild = $transformerData['transformer']->transform($field, $extensions, $transformerData['widget']);
            $transformedChild['name'] = $name;
            $data[] = $transformedChild;

            if ($transformerData['transformer']->isRequired($field)) {
                $required[] = $field->getName();
            }
        }

        $schema = [
            'title' => $form->getConfig()->getOption('label'),
            'type' => 'object',
            'properties' => $data,
            'form' => $form->getConfig()->getOption('form'),
        ];

        if($form->isRoot()) {
            $schema['csrf'] = $this->tokenManager->getToken($form->getName())->getValue();
        }

        if(!empty($form->getConfig()->getOption('deleteBtnLabel'))) {
            $schema['deleteBtnLabel'] = $form->getConfig()->getOption('deleteBtnLabel');
        }

        if(!empty($form->getConfig()->getOption('deleteConfirm'))) {
            $schema['deleteConfirm'] = $form->getConfig()->getOption('deleteConfirm');
        }

        if(!empty($form->getConfig()->getOption('disable_delete'))) {
            $schema['disable_delete'] = $form->getConfig()->getOption('disable_delete');
        }

        if(!empty($form->getConfig()->getOption('disable_submit'))) {
            $schema['disable_submit'] = $form->getConfig()->getOption('disable_submit');
        }

        if(!empty($form->getConfig()->getOption('tree_group'))) {
            $schema['tree_group'] = $form->getConfig()->getOption('tree_group');
        }

        if (!empty($required)) {
            $schema['required'] = $required;
        }

        $innerType = $form->getConfig()->getType()->getInnerType();

        $schema = $this->addCommonSpecs($form, $schema, $extensions, $widget);

        if (method_exists($innerType, 'buildLiform')) {
            $schema = $innerType->buildLiform($form, $schema);
        }

        return $schema;
    }
}