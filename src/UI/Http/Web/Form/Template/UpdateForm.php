<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Form\Template;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Application\Command\Template\UpdateCommand;
use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\Domain\Template\Event\UpdateForm as UpdateFormEvent;
use Zentlix\MainBundle\UI\Http\Web\FormType\AbstractForm;
use Zentlix\MainBundle\UI\Http\Web\FormType\AttributeType;
use Zentlix\MainBundle\UI\Http\Web\Type;

class UpdateForm extends AbstractForm
{
    private EventDispatcherInterface $eventDispatcher;
    private TranslatorInterface $translator;

    public function __construct(EventDispatcherInterface $eventDispatcher, TranslatorInterface $translator)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $command = $builder->getData();

        $main = $builder->create('main', Type\FormType::class, ['inherit_data' => true, 'label' => 'zentlix_main.main'])
            ->add('title', Type\TextType::class, [
                'label' => 'zentlix_main.title'
            ])
            ->add('sort', Type\IntegerType::class, [
                'label'       => 'zentlix_main.sort',
                'data'        => $command->sort,
                'constraints' => [
                    new GreaterThan(['value' => 0, 'message' => $this->translator->trans('zentlix_main.validation.greater_0')])
                ]
            ]);

        $builder->add($main);

        $builder->add($builder->create('attributes', AttributeType::class, [
            'label'  => 'zentlix_main.additional',
            'entity' => $command->getEntity(),
            'code'   => Template::getEntityCode()
        ]));

        $this->eventDispatcher->dispatch(new UpdateFormEvent($builder));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => UpdateCommand::class]);
    }
}