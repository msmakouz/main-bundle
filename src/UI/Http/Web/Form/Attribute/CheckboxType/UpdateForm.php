<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Form\Attribute\CheckboxType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zentlix\MainBundle\Application\Command\Attribute\UpdateCommand;
use Zentlix\MainBundle\Domain\Attribute\Event\Type\CheckboxType\UpdateForm as UpdateFormEvent;

class UpdateForm extends Form
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $this->eventDispatcher->dispatch(new UpdateFormEvent($builder));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => UpdateCommand::class]);
    }
}
