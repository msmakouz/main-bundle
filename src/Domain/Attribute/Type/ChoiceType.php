<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;
use Zentlix\MainBundle\Application\Command\Attribute\CreateCommand;
use Zentlix\MainBundle\Application\Command\Attribute\UpdateCommand;
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;
use Zentlix\MainBundle\Domain\Attribute\Entity\Value;
use Zentlix\MainBundle\Domain\Attribute\Repository\ValueRepository;
use Zentlix\MainBundle\Infrastructure\Attribute\Entity\SupportAttributeInterface;
use Zentlix\MainBundle\Infrastructure\Attribute\Type\AbstractChoiceType;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\ChoiceType\CreateForm;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\ChoiceType\UpdateForm;
use Zentlix\MainBundle\UI\Http\Web\Type;
use function is_array;

final class ChoiceType extends AbstractChoiceType implements AttributeTypeInterface
{
    private FormFactoryInterface $formFactory;
    private Environment $twig;
    private ValueRepository $repository;

    public function __construct(FormFactoryInterface $formFactory, Environment $twig, ValueRepository $repository)
    {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->repository = $repository;
    }

    public function normalizeValue($value, Attribute $attribute)
    {
        if(!is_array($value)) {
            $value = [$value];
        }

        $config = $attribute->getConfig();

        $values = [];
        /** @var Value $val */
        foreach ($value as $val) {
            $values[] = $config['choices'][(int) $val->getValue()] ?? null;
        }

        return (bool) $config['multiple'] ? $values : array_shift($values);
    }

    public function normalizeSavedValue($value)
    {
        return (int) $value;
    }

    public function getCreateForm(array $options = []): string
    {
        return $this->twig->render('@MainBundle/admin/attributes/types/create.html.twig', [
            'form'   => $this->formFactory->create(CreateForm::class, new CreateCommand($options['entity']))->createView(),
            'entity' => $options['entity']
        ]);
    }

    public function getUpdateForm($attribute, array $options = []): string
    {
        return $this->twig->render('@MainBundle/admin/attributes/types/update.html.twig', [
            'form'      => $this->formFactory->create(UpdateForm::class, new UpdateCommand($attribute))->createView(),
            'attribute' => $attribute
        ]);
    }

    public function buildField(FormBuilderInterface $builder, array $options, Attribute $attribute, SupportAttributeInterface $entity = null): void
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'required' => false,
            'multiple' => false,
            'choices'  => []
        ]);
        $config = $resolver->resolve($attribute->getConfig());

        $values = [];
        if($entity) {
            foreach ($this->repository->findByAttributeAndEntity($attribute->getId(), $entity->getId()) as $value) {
                $values[] = (int) $value->getValue();
            }
        }

        $builder->add($attribute->getCode(), Type\ChoiceType::class, [
            'label'    => $attribute->getTitle(),
            'choices'  => array_flip($config['choices']),
            'data'     => (bool) $config['multiple'] ? $values : array_shift($values),
            'required' => (bool) $config['required'],
            'multiple' => (bool) $config['multiple']
        ]);
    }
}