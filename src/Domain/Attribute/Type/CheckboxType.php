<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Twig\Environment;
use Zentlix\MainBundle\Application\Command\Attribute\CreateCommand;
use Zentlix\MainBundle\Application\Command\Attribute\UpdateCommand;
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;
use Zentlix\MainBundle\Domain\Attribute\Repository\ValueRepository;
use Zentlix\MainBundle\Infrastructure\Attribute\Entity\SupportAttributeInterface;
use Zentlix\MainBundle\Infrastructure\Attribute\Type\AbstractCheckboxType;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\CheckboxType\CreateForm;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\CheckboxType\UpdateForm;
use Zentlix\MainBundle\UI\Http\Web\Type;

final class CheckboxType extends AbstractCheckboxType implements AttributeTypeInterface
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

    public function normalizeValue($value, Attribute $attribute): bool
    {
        return (bool) $value->getValue();
    }

    public function normalizeSavedValue($value)
    {
        if (\is_bool($value)) {
            return true === $value ? 1 : 0;
        }

        return (int) $value;
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
        $value = null;
        if ($entity) {
            $value = $this->repository->findOneByAttributeAndEntity($attribute->getId(), $entity->getId());
        }

        $builder->add($attribute->getCode(), Type\CheckboxType::class, [
            'label' => $attribute->getTitle(),
            'data' => !\is_null($value) ? (bool) $value->getValue() : false,
        ]);
    }
}
