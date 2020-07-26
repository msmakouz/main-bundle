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
use Limenius\Liform\FormUtil;

class StringTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form, array $extensions = [], $widget = null)
    {
        $schema = ['type' => 'string'];
        $schema = $this->addCommonSpecs($form, $schema, $extensions, $widget);
        $schema = $this->addMaxLength($form, $schema);
        $schema = $this->addMinLength($form, $schema);
        $schema['value'] = $form->getData();
        $schema['disabled'] = $form->isDisabled();

        if($form->getErrors()->count()) {
            foreach ($form->getErrors() as $error) {
                $schema['errors'][] = $error->getMessage();
            }
        }

        $formView = $form->createView();

        if(!empty($formView->vars['specification'])) {
            $schema['specification'] = $formView->vars['specification'];
        }
        if(!empty($formView->vars['help'])) {
            $schema['help'] = $formView->vars['help'];
        }
        if(!empty($formView->vars['prepend'])) {
            $schema['prepend'] = $formView->vars['prepend'];
        }

        return $schema;
    }

    protected function addMaxLength(FormInterface $form, array $schema): array
    {
        if ($attr = $form->getConfig()->getOption('attr')) {
            if (isset($attr['maxlength'])) {
                $schema['maxLength'] = $attr['maxlength'];
            }
        }

        return $schema;
    }

    protected function addMinLength(FormInterface $form, array $schema): array
    {
        if (null === $this->validatorGuesser) {
            return $schema;
        }

        $class = FormUtil::findDataClass($form);

        if (null === $class) {
            return $schema;
        }

        $minLengthGuess = $this->validatorGuesser->guessMinLength($class, $form->getName());
        $minLength = $minLengthGuess ? $minLengthGuess->getValue() : null;

        if ($minLength) {
            $schema['minLength'] = $minLength;
        }

        return $schema;
    }
}