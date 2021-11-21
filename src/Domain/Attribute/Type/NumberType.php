<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;
use Zentlix\MainBundle\Application\Command\Attribute\CreateCommand;
use Zentlix\MainBundle\Application\Command\Attribute\UpdateCommand;
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;
use Zentlix\MainBundle\Domain\Attribute\Repository\ValueRepository;
use Zentlix\MainBundle\Infrastructure\Attribute\Entity\SupportAttributeInterface;
use Zentlix\MainBundle\Infrastructure\Attribute\Type\AbstractNumberType;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\NumberType\CreateForm;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\NumberType\UpdateForm;
use Zentlix\MainBundle\UI\Http\Web\Type;

final class NumberType extends AbstractNumberType implements AttributeTypeInterface
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
        $config = $attribute->getConfig();

        if ($config['integer']) {
            return (int) $value->getValue();
        }

        return (float) $value->getValue();
    }

    public function normalizeSavedValue($value)
    {
        return $value;
    }

    public function getCreateForm(array $options = []): string
    {
        return $this->twig->render('@MainBundle/admin/attributes/types/create.html.twig', [
            'form' => $this->formFactory->create(CreateForm::class, new CreateCommand($options['entity']))
                ->createView(),
            'entity' => $options['entity'],
        ]);
    }

    public function getUpdateForm($attribute, array $options = []): string
    {
        return $this->twig->render('@MainBundle/admin/attributes/types/update.html.twig', [
            'form' => $this->formFactory->create(UpdateForm::class, new UpdateCommand($attribute))->createView(),
            'attribute' => $attribute,
        ]);
    }

    public function buildField(
        FormBuilderInterface $builder,
        array $options,
        Attribute $attribute,
        SupportAttributeInterface $entity = null
    ): void {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'required' => false,
            'integer' => false,
            'default' => null,
        ]);
        $config = $resolver->resolve($attribute->getConfig());

        $type = Type\NumberType::class;
        $value = $this->getValue($attribute->getId(), $config['default'], $entity);

        if ($config['integer']) {
            $type = Type\IntegerType::class;
            $value = (int) $value;
        }

        $builder->add($attribute->getCode(), $type, [
            'label' => $attribute->getTitle(),
            'required' => (bool) $config['required'],
            'data' => $value,
        ]);
    }

    private function getValue($attributeId, $default = null, $entity = null)
    {
        if ($entity) {
            $value = $this->repository->findOneByAttributeAndEntity($attributeId, $entity->getId());

            if ($value) {
                return (float) $value->getValue();
            }
        }

        return $default ? (float) $default : null;
    }
}
