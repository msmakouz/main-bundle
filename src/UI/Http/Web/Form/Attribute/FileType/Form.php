<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Form\Attribute\FileType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Application\Command\Attribute\CreateCommand;
use Zentlix\MainBundle\Domain\Attribute\Repository\AttributeRepository;
use Zentlix\MainBundle\Domain\Attribute\Type\FileType;
use Zentlix\MainBundle\UI\Http\Web\FormType\AbstractForm;
use Zentlix\MainBundle\UI\Http\Web\Type;

class Form extends AbstractForm
{
    protected EventDispatcherInterface $eventDispatcher;
    private TranslatorInterface $translator;
    private AttributeRepository $repository;

    public function __construct(EventDispatcherInterface $eventDispatcher,
                                TranslatorInterface $translator,
                                AttributeRepository $repository)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->translator = $translator;
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $command = $builder->getData();

        $builder
            ->add('title', Type\TextType::class, [
                'label' => 'zentlix_main.title'
            ])
            ->add('code', Type\TextType::class, [
                'label'    => 'zentlix_main.symbol_code',
                'required' => false
            ])
            ->add('multiple', Type\CheckboxType::class, [
                'label' => 'zentlix_main.attribute.multiple'
            ])
            ->add('active', Type\CheckboxType::class, [
                'label' => 'zentlix_main.attribute.active'
            ])
            ->add('sort', Type\IntegerType::class, [
                'label'       => 'zentlix_main.sort',
                'data'        => $command instanceof CreateCommand ? $this->repository->getMaxSort($command->attributeEntity) + 1 : $command->sort,
                'constraints' => [
                    new GreaterThan(['value' => 0, 'message' => $this->translator->trans('zentlix_main.validation.greater_0')])
                ],
            ])
            ->add('form', Type\HiddenType::class, [
                'data'   => static::class,
                'mapped' => false
            ])
            ->add('attribute_type', Type\HiddenType::class, [
                'data' => FileType::getCode()
            ]);
    }
}