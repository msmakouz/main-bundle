<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Form\Setting;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zentlix\MainBundle\Application\Command\Setting\DefaultSettingCommand;
use Zentlix\MainBundle\UI\Http\Web\FormType\AbstractForm;

class DefaultForm extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => DefaultSettingCommand::class]);
    }
}
