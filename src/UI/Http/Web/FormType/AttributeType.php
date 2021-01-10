<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

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
use function count;

class AttributeType extends AbstractType
{
    private AttributeRepository $repository;
    private UrlGeneratorInterface $router;
    private TranslatorInterface $translator;
    private AttributeTypes $types;

    public function __construct(AttributeRepository $repository,
                                AttributeTypes $types,
                                UrlGeneratorInterface $router,
                                TranslatorInterface $translator)
    {
        $this->repository = $repository;
        $this->types = $types;
        $this->router = $router;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attributes = $this->repository->findActiveByEntity($options['code']);

        if(count($attributes) === 0) {
            $builder->add('create_attribute', AlertType::class, [
                'data' => sprintf(
                    $this->translator->trans('zentlix_main.attribute.create_attr'),
                    $this->router->generate('admin.attribute.manage', ['entity' => $options['code']])
                )
            ]);
        }

        foreach ($attributes as $attribute) {
            $this->types->getByCode($attribute->getAttributeType())->buildField($builder, $options, $attribute, $options['entity']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefined('entity');
        $resolver->setDefaults(['entity' => null]);
        $resolver->setRequired('code');
    }
}