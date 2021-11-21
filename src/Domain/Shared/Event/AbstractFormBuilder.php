<?php

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

    public function getFormBuilder(): FormBuilderInterface
    {
        return $this->formBuilder;
    }
}
