<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Event;

use Symfony\Component\Form\FormBuilderInterface;

class AbstractFormBuilder
{
    private FormBuilderInterface $formBuilder;

    public function __construct(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    public function getFormBuilder() :FormBuilderInterface
    {
        return $this->formBuilder;
    }
}