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
use Zentlix\MainBundle\Infrastructure\Attribute\Type\AbstractStringType;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\StringType\CreateForm;
use Zentlix\MainBundle\UI\Http\Web\Form\Attribute\StringType\UpdateForm;
use Zentlix\MainBundle\UI\Http\Web\Type\EmailType;
use Zentlix\MainBundle\UI\Http\Web\Type\PasswordType;
use Zentlix\MainBundle\UI\Http\Web\Type\TextareaType;
use Zentlix\MainBundle\UI\Http\Web\Type\TextType;
use Zentlix\UserBundle\Domain\User\ValueObject\Email;

final class StringType extends AbstractStringType implements AttributeTypeInterface
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
        if ('email' === $config['type']) {
            return new Email($value->getValue());
        }

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
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'type' => 'text',
            'required' => false,
            'default' => null,
        ]);
        $config = $resolver->resolve($attribute->getConfig());

        $value = null;
        if ($entity) {
            $value = $this->repository->findOneByAttributeAndEntity($attribute->getId(), $entity->getId());
        }

        switch ($config['type']) {
            case 'textarea':
                $type = TextareaType::class;
                break;
            case 'email':
                $type = EmailType::class;
                break;
            case 'password':
                $type = PasswordType::class;
                break;
            default:
                $type = TextType::class;
        }

        $params = [
            'label' => $attribute->getTitle(),
            'required' => (bool) $config['required'],
            'data' => !\is_null($value) ? (string) $value->getValue() : (string) $config['default'],
        ];

        $builder->add($attribute->getCode(), $type, $params);
    }
}
