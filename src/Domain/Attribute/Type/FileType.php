<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;
use Zentlix\MainBundle\Application\Command\Attribute\CreateCommand;
use Zentlix\MainBundle\Application\Command\Attribute\UpdateCommand;
use Zentlix\MainBundle\Application\Query\File\GetFileByIdQuery;
use Zentlix\MainBundle\Application\Query\File\GetFileByPathQuery;
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;
use Zentlix\MainBundle\Domain\Attribute\Entity\Value;
use Zentlix\MainBundle\Domain\Attribute\Repository\ValueRepository;
use Zentlix\MainBundle\Infrastructure\Attribute\Entity\SupportAttributeInterface;
use Zentlix\MainBundle\Infrastructure\Attribute\Type\AbstractFileType;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryBus;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\FileType\CreateForm;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\FileType\UpdateForm;
use Zentlix\MainBundle\UI\Http\Web\Type\FileStorageType;

final class FileType extends AbstractFileType implements AttributeTypeInterface
{
    private FormFactoryInterface $formFactory;
    private Environment $twig;
    private QueryBus $queryBus;
    private ValueRepository $repository;

    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        QueryBus $queryBus,
        ValueRepository $repository
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->queryBus = $queryBus;
        $this->repository = $repository;
    }

    public function normalizeValue($value, Attribute $attribute)
    {
        if (!\is_array($value)) {
            $value = [$value];
        }

        $config = $attribute->getConfig();

        $values = [];
        /** @var Value $val */
        foreach ($value as $val) {
            $values[] = $this->queryBus->handle(new GetFileByIdQuery($val->getValue()));
        }

        return (bool) $config['multiple'] ? $values : array_shift($values);
    }

    public function normalizeSavedValue($value)
    {
        $file = $this->queryBus->handle(new GetFileByPathQuery(trim($value)));

        return $file['id'];
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
            'multiple' => false,
        ]);
        $config = $resolver->resolve($attribute->getConfig());

        $values = [];
        if ($entity) {
            foreach ($this->repository->findByAttributeAndEntity($attribute->getId(), $entity->getId()) as $value) {
                $values[] = $this->queryBus->handle(new GetFileByIdQuery($value->getValue()))['url'];
            }
        }

        $builder->add($attribute->getCode(), FileStorageType::class, [
            'label' => $attribute->getTitle(),
            'data' => $config['multiple'] ? $values : array_shift($values),
            'savePath' => 'attributes',
            'attr' => [
                'class' => $config['multiple'] ? '' : 'dropzone-boxed',
            ],
        ]);
    }
}
