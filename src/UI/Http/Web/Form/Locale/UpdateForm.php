<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Form\Locale;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Zentlix\MainBundle\Application\Command\Locale\UpdateCommand;
use Zentlix\MainBundle\Domain\Locale\Event\UpdateForm as UpdateFormEvent;
use Zentlix\MainBundle\UI\Http\Web\FormType\AbstractForm;
use Zentlix\MainBundle\UI\Http\Web\Type;

class UpdateForm extends AbstractForm
{
    protected EventDispatcherInterface $eventDispatcher;
    protected TranslatorInterface $translator;

    public function __construct(EventDispatcherInterface $eventDispatcher, TranslatorInterface $translator)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', Type\TextType::class, ['label' => 'zentlix_main.title'])
            ->add('sort', Type\IntegerType::class, [
                'label' => 'zentlix_main.sort',
                'constraints' => [
                    new GreaterThan(['value' => 0, 'message' => $this->translator->trans('zentlix_main.validation.greater_0')])
                ]
            ]);

        $this->eventDispatcher->dispatch(new UpdateFormEvent($builder));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => UpdateCommand::class]);
    }
}