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
use Zentlix\MainBundle\Domain\Attribute\Entity\Value;
use Zentlix\MainBundle\Domain\Attribute\Repository\ValueRepository;
use Zentlix\MainBundle\Domain\Attribute\Service\Relations;
use Zentlix\MainBundle\Infrastructure\Attribute\Entity\SupportAttributeInterface;
use Zentlix\MainBundle\Infrastructure\Attribute\Type\AbstractRelationType;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\RelationType\CreateForm;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\RelationType\UpdateForm;
use Zentlix\MainBundle\UI\Http\Web\Type\ChoiceType;

final class RelationType extends AbstractRelationType implements AttributeTypeInterface
{
    private FormFactoryInterface $formFactory;
    private Environment $twig;
    private Relations $relations;
    private ValueRepository $repository;

    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        Relations $relations,
        ValueRepository $repository
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->relations = $relations;
        $this->repository = $repository;
    }

    public function normalizeValue($value, Attribute $attribute)
    {
        if (!\is_array($value)) {
            $value = [$value];
        }

        $config = $attribute->getConfig();

        $elementIds = [];
        /** @var Value $val */
        foreach ((array) $value as $val) {
            $elementIds[] = $val->getValue();
        }

        return $this->relations->getByCode($config['relation'])->getElements($elementIds);
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
            'relation' => null,
            'required' => false,
            'multiple' => false,
        ]);
        $config = $resolver->resolve($attribute->getConfig());

        $values = [];
        if ($entity) {
            foreach ($this->repository->findByAttributeAndEntity($attribute->getId(), $entity->getId()) as $value) {
                $values[] = (int) $value->getValue();
            }
        }

        $builder->add($attribute->getCode(), ChoiceType::class, [
            'label' => $attribute->getTitle(),
            'choices' => $this->relations->getByCode($config['relation'])->getElementsAssoc(),
            'data' => (bool) $config['multiple'] ? $values : array_shift($values),
            'required' => (bool) $config['required'],
            'multiple' => (bool) $config['multiple'],
        ]);
    }
}
