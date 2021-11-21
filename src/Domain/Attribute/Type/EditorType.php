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
use Zentlix\MainBundle\Infrastructure\Attribute\Type\AbstractEditorType;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\EditorType\CreateForm;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\EditorType\UpdateForm;
use Zentlix\MainBundle\UI\Http\Web\Type;

final class EditorType extends AbstractEditorType implements AttributeTypeInterface
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
        return (string) $value->getValue();
    }

    public function normalizeSavedValue($value)
    {
        return (string) trim($value);
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
        $config = $attribute->getConfig();

        $value = null;
        if ($entity) {
            $value = $this->repository->findOneByAttributeAndEntity($attribute->getId(), $entity->getId());
        }

        $builder->add($attribute->getCode(), Type\EditorType::class, [
            'label' => $attribute->getTitle(),
            'data' => !\is_null($value) ? (string) $value->getValue() : (string) $config['default'],
        ]);
    }
}
