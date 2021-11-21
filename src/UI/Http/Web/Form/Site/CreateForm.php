<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Form\Site;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zentlix\MainBundle\Application\Command\Site\CreateCommand;
use Zentlix\MainBundle\Domain\Site\Event\CreateForm as CreateFormEvent;

class CreateForm extends Form
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $this->eventDispatcher->dispatch(new CreateFormEvent($builder));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => CreateCommand::class]);
    }
}
