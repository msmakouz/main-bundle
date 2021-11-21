<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\MainBundle\Domain\Attribute\Repository\AttributeRepository;
use Zentlix\MainBundle\Domain\Attribute\Service\AttributeTypes;
use Zentlix\MainBundle\UI\Http\Web\Type\AlertType;

class AttributeType extends AbstractType
{
    private AttributeRepository $repository;
    private UrlGeneratorInterface $router;
    private TranslatorInterface $translator;
    private AttributeTypes $types;

    public function __construct(
        AttributeRepository $repository,
        AttributeTypes $types,
        UrlGeneratorInterface $router,
        TranslatorInterface $translator
    ) {
        $this->repository = $repository;
        $this->types = $types;
        $this->router = $router;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $attributes = $this->repository->findActiveByEntity($options['code']);

        if (0 === \count($attributes)) {
            $builder->add('create_attribute', AlertType::class, [
                'data' => sprintf(
                    $this->translator->trans('zentlix_main.attribute.create_attr'),
                    $this->router->generate('admin.attribute.manage', ['entity' => $options['code']])
                ),
            ]);
        }

        foreach ($attributes as $attribute) {
            $this->types
                ->getByCode($attribute->getAttributeType())
                ->buildField($builder, $options, $attribute, $options['entity']);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefined('entity');
        $resolver->setDefaults(['entity' => null]);
        $resolver->setRequired('code');
    }
}
